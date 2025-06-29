@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-6xl pt-20">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-2/3">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Potvrzení objednávky</h2>

                @if ($errors->any())
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
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Téměř hotovo!</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Zkontrolujte prosím údaje o objednávce a potvrďte ji.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($paymentMethod !== 'cash_on_delivery')
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Platební údaje</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p class="font-medium">Banka: <span class="font-normal">Česká spořitelna</span></p>
                                <p class="font-medium">Číslo účtu: <span class="font-normal">4753073093/0800</span></p>
                                <p class="font-medium">Příjemce: <span class="font-normal">Yurii Kolesnyk</span></p>
                                <p class="font-medium">Částka k úhradě: <span class="font-normal">{{ number_format($depositAmount, 2) }} Kč</span></p>
                                <p class="font-medium">Variabilní symbol: <span class="font-normal">VS{{ now()->format('YmdHis') }}</span></p>
                                <p class="font-medium">Zpráva pro příjemce: <span class="font-normal">Truhlik na Miru</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Způsob dopravy:</h3>
                    <p class="text-gray-600">
                        @if($customerData['delivery_method'] === 'courier')
                            Doručení poštou ({{ number_format($deliveryCost, 2) }} Kč)
                        @else
                            Osobní odběr (zdarma)
                        @endif
                    </p>
                    @if($customerData['delivery_method'] === 'courier' && !empty($customerData['address']))
                    <h4 class="text-md font-medium text-gray-800 mt-3">Doručovací adresa:</h4>
                    <p class="text-gray-600 whitespace-pre-line">{{ $customerData['address'] }}</p>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Způsob platby:</h3>
                    <p class="text-gray-600">
                        @if($paymentMethod === 'full_prepayment')
                            Plná předplatba (100%) - {{ number_format($depositAmount, 2) }} Kč
                        @elseif($paymentMethod === 'partial_prepayment')
                            Částečná předplatba (50%) - {{ number_format($depositAmount, 2) }} Kč nyní +
                            {{ number_format($total - $depositAmount, 2) }} Kč při převzetí
                        @else
                            Platba při převzetí - {{ number_format($total, 2) }} Kč
                        @endif
                    </p>
                </div>

                <form action="{{ route('checkout.complete') }}" method="POST" id="order-form">
                    @csrf
                    <div class="mb-6">
                        <label for="notes" class="block text-gray-700 font-medium mb-2">Poznámka k objednávce</label>
                        <textarea id="notes" name="notes"
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                                  rows="3" placeholder="Volitelné poznámky k objednávce...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="agree_terms" name="agree_terms" type="checkbox"
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                       {{ old('agree_terms') ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="agree_terms" class="text-sm text-gray-700">
                                    Souhlasím s <a href="{{ route('page.terms') }}" class="text-green-600 hover:text-green-500">obchodními podmínkami</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <a href="{{ route('checkout.step2') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                            Zpět
                        </a>
                        <button type="submit" id="submit-button"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-300 flex items-center">
                            <span id="submit-text">Potvrdit objednávku</span>
                            <span id="spinner" class="hidden ml-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="md:w-1/3">
            @include('checkout.partials.summary')
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('order-form');
    const submitButton = document.getElementById('submit-button');
    const submitText = document.getElementById('submit-text');
    const spinner = document.getElementById('spinner');

    if (form && submitButton) {
        form.addEventListener('submit', function() {
            // Блокировка кнопки и показ индикатора загрузки
            submitButton.disabled = true;
            submitText.textContent = 'Zpracovává se...';
            spinner.classList.remove('hidden');
        });
    }
});
</script>
@endpush
@endsection
