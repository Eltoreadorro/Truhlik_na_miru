@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-6xl pt-20">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-2/3">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Způsob platby</h2>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <h4 class="text-lg font-medium text-blue-800 mb-2">Důležité informace:</h4>
                    <ul class="list-disc pl-5 space-y-1 text-blue-700">
                        <li>Po odeslání objednávky obdržíte platební údaje</li>
                        <li>Na pokrytí nákladů na výrobu produktu je vyžadována platba předem</li>
                        <li>Zboží expedujeme po připsání platby na náš účet</li>
                    </ul>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Chyby ve formuláři</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('checkout.step2.process') }}" method="POST" id="payment-form">
                    @csrf

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Vybraný způsob dopravy:</h3>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            @if($customerData['delivery_method'] === 'courier')
                                <p class="font-medium">Doručení poštou</p>
                                <p class="text-gray-600">Cena dopravy: {{ number_format($deliveryCost, 2) }} Kč</p>
                                @if(!empty($customerData['address']))
                                    <p class="text-gray-600 mt-2">Adresa: {{ $customerData['address'] }}</p>
                                @endif
                            @else
                                <p class="font-medium">Osobní odběr</p>
                                <p class="text-gray-600">Bez poplatku za dopravu</p>
                                <p class="text-gray-600 mt-2">Adresa výdejního místa: Sulicka 42, Sulice, 25168 Praha-vychod</p>
                            @endif
                        </div>

                        <h3 class="text-lg font-medium text-gray-800 mb-4">Vyberte způsob platby:</h3>
                        <div class="space-y-4" x-data="{ selectedPayment: '{{ old('payment_method', session('checkout.step2.payment_method') ?? '') }}' }">
                            <!-- Полная предоплата -->
                            <div class="relative">
                                <input type="radio" name="payment_method"
                                       id="full_prepayment" value="full_prepayment"
                                       x-model="selectedPayment"
                                       class="hidden">
                                <label for="full_prepayment"
                                       @click="selectedPayment = 'full_prepayment'"
                                       :class="{
                                           'border-green-500 bg-green-50': selectedPayment === 'full_prepayment',
                                           'border-gray-200': selectedPayment !== 'full_prepayment'
                                       }"
                                       class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-green-400 transition-all">
                                    <div class="flex items-center">
                                        <div class="w-5 h-5 border-2 rounded-full mr-3 flex-shrink-0"
                                             :class="{
                                                 'border-green-500 bg-green-500': selectedPayment === 'full_prepayment',
                                                 'border-gray-300': selectedPayment !== 'full_prepayment'
                                             }"></div>
                                        <div>
                                            <span class="font-medium text-lg block">Plná předplatba (100%)</span>
                                            <span class="text-gray-500 text-sm">
                                                Platba celé částky {{ number_format($total, 2) }} Kč předem
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-green-600 font-medium">
                                        {{ number_format($total, 2) }} Kč
                                    </span>
                                </label>
                            </div>

                            <!-- Частичная предоплата -->
                            <div class="relative">
                                <input type="radio" name="payment_method"
                                       id="partial_prepayment" value="partial_prepayment"
                                       x-model="selectedPayment"
                                       class="hidden">
                                <label for="partial_prepayment"
                                       @click="selectedPayment = 'partial_prepayment'"
                                       :class="{
                                           'border-green-500 bg-green-50': selectedPayment === 'partial_prepayment',
                                           'border-gray-200': selectedPayment !== 'partial_prepayment'
                                       }"
                                       class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-green-400 transition-all">
                                    <div class="flex items-center">
                                        <div class="w-5 h-5 border-2 rounded-full mr-3 flex-shrink-0"
                                             :class="{
                                                 'border-green-500 bg-green-500': selectedPayment === 'partial_prepayment',
                                                 'border-gray-300': selectedPayment !== 'partial_prepayment'
                                             }"></div>
                                        <div>
                                            <span class="font-medium text-lg block">Částečná předplatba (50%)</span>
                                            <span class="text-gray-500 text-sm">
                                                {{ number_format($total * 0.5, 2) }} Kč nyní +
                                                {{ number_format($total * 0.5, 2) }} Kč
                                                @if($customerData['delivery_method'] === 'courier')
                                                    při doručení
                                                @else
                                                    při převzetí
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-green-600 font-medium">
                                        {{ number_format($total * 0.5, 2) }} Kč
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <a href="{{ route('checkout.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                            Zpět
                        </a>
                        <button type="submit" id="submit-button"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg">
                            Pokračovat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="md:w-1/3">
            @include('checkout.partials.summary', [
                'cartService' => $cartService,
                'customerData' => $customerData,
                'total' => $total,
                'deliveryCost' => $deliveryCost
            ])
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');

    if (form && submitButton) {
        form.addEventListener('submit', function(e) {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!selectedMethod) {
                e.preventDefault();
                alert('Prosím vyberte způsob platby');
                return false;
            }

            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Zpracovává se...
            `;
        });
    }
});
</script>
@endpush
@endsection
