<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-green-600 text-white px-6 py-4">
        <h5 class="text-xl font-bold">Shrnutí objednávky</h5>
    </div>
    <div class="p-6">
        @isset($customerData)
        <div class="mb-6">
            <h6 class="font-medium text-gray-800 mb-2">Kontaktní údaje:</h6>
            <p class="text-sm text-gray-600">{{ $customerData['customer_name'] }}</p>
            <p class="text-sm text-gray-600">{{ $customerData['phone'] }}</p>
            @if(!empty($customerData['email']))
            <p class="text-sm text-gray-600">{{ $customerData['email'] }}</p>
            @endif

            <h6 class="font-medium text-gray-800 mt-4 mb-2">Způsob dopravy:</h6>
            <p class="text-sm text-gray-600">
                @if($customerData['delivery_method'] === 'courier')
                    Doručení poštou (+200 Kč)
                @else
                    Osobní odběr (zdarma)
                @endif
            </p>

            @if($customerData['delivery_method'] === 'courier' && !empty($customerData['address']))
            <h6 class="font-medium text-gray-800 mt-3 mb-1">Adresa:</h6>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $customerData['address'] }}</p>
            @endif
        </div>
        <div class="border-t border-gray-200 my-4"></div>
        @endisset

        <h6 class="font-medium text-gray-800 mb-3">Produkty:</h6>
        <ul class="divide-y divide-gray-200">
            @foreach($cartService->getCartItemsWithDetails() as $item)
            <li class="py-3 flex justify-between items-start">
                <div class="flex items-start">
                    @if($item['variant']->product->hasMedia('main'))
                    <img src="{{ $item['variant']->product->getFirstMediaUrl('main', 'thumb') }}"
                         class="h-12 w-12 object-cover rounded mr-3">
                    @else
                    <div class="h-12 w-12 bg-gray-100 rounded mr-3 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400"></i>
                    </div>
                    @endif
                    <div>
                        <h6 class="font-medium text-gray-800">{{ $item['variant']->product->name }}</h6>
                        <p class="text-sm text-gray-500">
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium"
                                  style="background-color: {{ $item['color_hex'] }}; color: {{ $item['variant']->color_data->contrast_color }}">
                                {{ $item['color_name'] }}
                            </span>
                            @if($item['dimensions'])
                            <span class="ml-1">{{ $item['dimensions'] }}</span>
                            @endif
                            × {{ $item['quantity'] }}
                        </p>
                    </div>
                </div>
                <span class="font-medium">{{ number_format($item['price'] * $item['quantity'], 2) }} Kč</span>
            </li>
            @endforeach
        </ul>

        <div class="border-t border-gray-200 my-4"></div>

        <div class="flex justify-between py-2">
            <span class="text-gray-600">Doprava:</span>
            <span class="font-medium">
                @isset($customerData)
                    @if($customerData['delivery_method'] === 'courier')
                        200 Kč
                    @else
                        0 Kč
                    @endif
                @else
                    0 Kč
                @endisset
            </span>
        </div>

        <div class="flex justify-between py-3 font-bold text-lg">
            <span>Celkem:</span>
            <span class="text-green-600">
                {{ number_format($total ?? $cartService->getTotal(), 2) }} Kč
            </span>
        </div>
    </div>
</div>
