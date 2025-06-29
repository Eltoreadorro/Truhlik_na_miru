<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\OrderConfirmationNotification;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index()
    {
        if (!$this->cartService->getItems()) {
            return redirect()->route('cart.index')->with('error', 'Váš nákupní košík je prázdný');
        }

        $userData = [];
        if (auth()->check()) {
            $user = auth()->user();
            $userData = [
                'customer_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone
            ];
        }

        return view('checkout.step1', [
            'cartService' => $this->cartService,
            'userData' => $userData
        ]);
    }

    public function updateSummary(Request $request)
    {
        $deliveryMethod = $request->input('delivery_method', 'pickup');
        $subtotal = $this->cartService->getTotal();
        $total = $subtotal + ($deliveryMethod === 'courier' ? 200 : 0);

        return response()->json([
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2)
        ]);
    }

    public function processStep1(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'email' => 'nullable|email',
            'delivery_method' => 'required|in:pickup,courier'
        ];

        if ($request->delivery_method === 'courier') {
            $rules['address'] = 'required|string|max:500';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        if ($validated['delivery_method'] === 'pickup') {
            $validated['address'] = '';
        }

        session()->put('checkout.step1', $validated);
        return redirect()->route('checkout.step2');
    }

    public function step2()
    {
        if (!session()->has('checkout.step1')) {
            return redirect()->route('checkout.index')->with('error', 'Prosím vyplňte údaje o dopravě');
        }

        $step1Data = session('checkout.step1');
        $deliveryCost = $step1Data['delivery_method'] === 'courier' ? 200 : 0;
        $cartTotal = $this->cartService->getTotal();
        $total = $cartTotal + $deliveryCost;

        return view('checkout.step2', [
        'cartService' => $this->cartService,
        'customerData' => $step1Data,
        'deliveryCost' => $deliveryCost,
        'total' => $total,
        // Добавьте если нужно:
        'selectedPayment' => session('checkout.step2.payment_method', '')
    ]);
    }

    public function processStep2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:full_prepayment,partial_prepayment'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $step1Data = session('checkout.step1');
        $deliveryCost = $step1Data['delivery_method'] === 'courier' ? 200 : 0;
        $cartTotal = $this->cartService->getTotal();
        $total = $cartTotal + $deliveryCost;

        $depositAmount = $request->payment_method === 'partial_prepayment'
            ? $total * 0.5
            : $total;

        session()->put('checkout.step2', [
            'payment_method' => $request->payment_method,
            'deposit_amount' => $depositAmount,
            'total_amount' => $total
        ]);

        return redirect()->route('checkout.step3');
    }

    public function step3()
    {
        if (!session()->has('checkout.step1') || !session()->has('checkout.step2')) {
            return redirect()->route('checkout.index')->with('error', 'Prosím dokončete všechny kroky objednávky');
        }

        $step1Data = session('checkout.step1');
        $step2Data = session('checkout.step2');
        $deliveryCost = $step1Data['delivery_method'] === 'courier' ? 200 : 0;
        $cartTotal = $this->cartService->getTotal();
        $total = $cartTotal + $deliveryCost;

        return view('checkout.step3', [
            'cartService' => $this->cartService,
            'customerData' => $step1Data,
            'paymentData' => $step2Data,
            'deliveryCost' => $deliveryCost,
            'total' => $total,
            'paymentMethod' => $step2Data['payment_method'],
            'depositAmount' => $step2Data['deposit_amount']
        ]);
    }

    public function complete(Request $request)
{
    // Валидация
    $validator = Validator::make($request->all(), [
        'agree_terms' => 'required|accepted'
    ], [
        'agree_terms.required' => 'Musíte souhlasit s obchodními podmínkami',
        'agree_terms.accepted' => 'Musíte souhlasit s obchodními podmínkami'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Проверка данных сессии и корзины
    if (!session()->has('checkout.step1') || !session()->has('checkout.step2')) {
        return redirect()->route('checkout.index')
            ->with('error', 'Session expired. Please start over.');
    }

    $cartItems = $this->cartService->getCartItemsWithDetails();
    if (empty($cartItems)) {
        return redirect()->route('checkout.index')
            ->with('error', 'Váš košík je prázdný');
    }

    DB::beginTransaction();

    try {
        $step1Data = session('checkout.step1');
        $step2Data = session('checkout.step2');

        // Расчет стоимости
        $deliveryCost = $step1Data['delivery_method'] === 'courier' ? 200 : 0;
        $subtotal = $this->cartService->getTotal();
        $total = $subtotal + $deliveryCost;
        $variableSymbol = 'VS' . now()->format('YmdHis');

        // Создание заказа
        $orderData = [
            'customer_name' => $step1Data['customer_name'],
            'phone' => $step1Data['phone'],
            'email' => $step1Data['email'] ?? null,
            'address' => $step1Data['address'] ?? null,
            'total' => $total,
            'status' => Order::STATUS_NEW,
            'payment_method' => $step2Data['payment_method'],
            'payment_status' => 'pending',
            'delivery_method' => $step1Data['delivery_method'],
            'deposit_amount' => $step2Data['deposit_amount'],
            'notes' => $request->input('notes', ''),
            'variable_symbol' => $variableSymbol,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];

        if (auth()->check()) {
            $orderData['user_id'] = auth()->id();
        }

        $order = Order::create($orderData);

        // Добавление товаров
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $item['variant']->id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'color' => $item['color_hex'],
                'dimensions' => $item['dimensions']
            ]);
        }

        // Создание платежа (если не наложенный платеж)
        if ($step2Data['payment_method'] !== 'cash_on_delivery') {
            Payment::create([
                'order_id' => $order->id,
                'amount' => $step2Data['deposit_amount'],
                'method' => $step2Data['payment_method'],
                'status' => 'pending',
                'variable_symbol' => $variableSymbol,
                'details' => json_encode([
                    'bank_account' => config('app.bank_account', '4753073093/0800'),
                    'bank_name' => config('app.bank_name', 'Česká spořitelna'),
                    'recipient' => config('app.name', 'Truhlik na Miru')
                ])
            ]);
        }

        DB::commit();

        // Очистка сессии и корзины
        session()->forget(['cart', 'checkout.step1', 'checkout.step2']);
        $this->cartService->clear();

        // Перенаправление на страницу успеха
        return redirect()->route('checkout.success', $order);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order creation failed: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
            'session' => session()->all()
        ]);

        return redirect()->back()
            ->with('error', 'Nastala chyba při vytváření objednávky: ' . $e->getMessage())
            ->withInput();
    }
}

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}
