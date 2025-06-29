@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-6xl pt-20">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-2/3">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Kontaktní údaje</h2>

                <form action="{{ route('checkout.step1.process') }}" method="POST" id="checkout-form">
                    @csrf

                    <div class="mb-6">
                        <label for="customer_name" class="block text-gray-700 font-medium mb-2">Celé jméno *</label>
                        <input type="text" id="customer_name" name="customer_name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                            value="{{ old('customer_name', $userData['customer_name'] ?? '') }}" required>
                    </div>

                    <div class="mb-6">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Telefon *</label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                            value="{{ old('phone', $userData['phone'] ?? '') }}" required>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                            value="{{ old('email', $userData['email'] ?? '') }}">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-3">Způsob dopravy *</label>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input class="form-radio h-5 w-5 text-green-500 focus:ring-green-400"
                                    type="radio" name="delivery_method" id="pickup" value="pickup" checked>
                                <label for="pickup" class="ml-3 text-gray-700">
                                    <span class="font-medium">Osobní odběr</span>
                                    <p class="text-sm text-gray-500 mt-1">Adresu najdete na stránce kontakty</p>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input class="form-radio h-5 w-5 text-green-500 focus:ring-green-400"
                                    type="radio" name="delivery_method" id="courier" value="courier">
                                <label for="courier" class="ml-3 text-gray-700">
                                    <span class="font-medium">Doručení poštou (+200 Kč)</span>
                                    <p class="text-sm text-gray-500 mt-1">Doručení do 2-3 pracovních dnů</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 hidden" id="address-field">
                        <label for="address" class="block text-gray-700 font-medium mb-2">Doručovací adresa *</label>
                        <textarea id="address" name="address"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                                rows="3">{{ old('address') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg">
                        Pokračovat
                    </button>
                </form>
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
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="md:w-1/3">
            @include('checkout.partials.summary')
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delivery method toggle
    const deliveryMethodRadios = document.querySelectorAll('input[name="delivery_method"]');
    const addressField = document.getElementById('address-field');

    deliveryMethodRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'courier') {
                addressField.classList.remove('hidden');
            } else {
                addressField.classList.add('hidden');
            }
            updateSummary();
        });
    });

    // Update summary dynamically
    function updateSummary() {
        const formData = new FormData(document.getElementById('checkout-form'));
        const deliveryMethod = formData.get('delivery_method');
        const deliveryCost = deliveryMethod === 'courier' ? 200 : 0;

        fetch('{{ route("checkout.update-summary") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector('.summary-total').textContent = data.total + ' Kč';
            document.querySelector('.delivery-cost').textContent = deliveryCost + ' Kč';
        });
    }

    // Initial update
    updateSummary();
});
</script>
@endpush
@endsection
