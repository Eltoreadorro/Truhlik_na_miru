<div>
    @if (count($items) > 0)
        <h2 class="text-2xl font-bold mb-4">Váš nákupní košík</h2>

        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Produkt</th>
                        <th class="px-4 py-3 text-left">Varianta</th>
                        <th class="px-4 py-3 text-left">Cena</th>
                        <th class="px-4 py-3 text-left">Množství</th>
                        <th class="px-4 py-3 text-left">Celkem</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    @if ($item['variant']->product->hasMedia('main'))
    <img src="{{ $item['variant']->product->getFirstMediaUrl('main', 'thumb') }}"
        alt="{{ $item['variant']->product->name }}"
        class="h-16 w-16 object-cover rounded mr-3">
@else
    <div class="h-16 w-16 bg-gray-200 rounded mr-3 flex items-center justify-center">
        <i class="fas fa-image text-gray-400"></i>
    </div>
@endif
                                    <div>
                                        <a href="{{ route('products.show', $item['variant']->product) }}"
                                            class="font-medium hover:text-green-600">
                                            {{ $item['variant']->product->name }}
                                        </a>
                                        <p class="text-sm text-gray-500">{{ $item['variant']->product->category->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    style="background-color: {{ $item['variant']->color_data->hex_code }}; color: {{ $item['variant']->color_data->contrast_color }}">
                                    {{ $item['variant']->color_data->name }}
                                </span>
                                @if ($item['variant']->formatted_dimensions)
                                    <span class="ml-1 text-xs text-gray-500">
                                        ({{ $item['variant']->formatted_dimensions }})
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ number_format($item['price'], 0, ',', ' ') }} Kč</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <button wire:click="decrementQuantity({{ $item['variant']->id }})"
                                        class="bg-gray-200 px-2 py-1 rounded-l hover:bg-gray-300">
                                        −
                                    </button>
                                    <input type="number" value="{{ $item['quantity'] }}" min="1"
                                        class="w-12 text-center border-t border-b border-gray-300"
                                        wire:change="updateQuantity({{ $item['variant']->id }}, $event.target.value)">
                                    <button wire:click="incrementQuantity({{ $item['variant']->id }})"
                                        class="bg-gray-200 px-2 py-1 rounded-r hover:bg-gray-300">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-medium">
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} Kč
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button wire:click="removeItem({{ $item['variant']->id }})"
                                    class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="font-bold">Celková částka:</span>
                <span class="text-xl font-bold">{{ number_format($total, 0, ',', ' ') }} Kč</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('products.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg text-center transition">
                <i class="fas fa-arrow-left mr-2"></i> Pokračovat v nákupu
            </a>
            <a href="{{ route('checkout.index') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg text-center transition">
                Pokračovat k platbě <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-green-500 text-5xl mb-4">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Váš košík je prázdný</h3>
            <p class="text-gray-600 mb-4">Začněte přidávat produkty z našeho katalogu</p>
            <a href="{{ route('products.index') }}"
                class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition">
                <i class="fas fa-store mr-2"></i> Prohlédnout produkty
            </a>
        </div>
    @endif
</div>
