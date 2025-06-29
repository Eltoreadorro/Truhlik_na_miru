@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl pt-20">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-green-600 text-white px-8 py-6">
            <div class="flex items-center justify-center">
                <svg class="h-12 w-12 text-white mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <h2 class="text-3xl font-bold">Objednávka úspěšně dokončena!</h2>
            </div>
        </div>
        <div class="p-8">
            <div class="mb-8 text-center">
                <h3 class="text-2xl font-medium text-gray-800 mb-2">Číslo vaší objednávky</h3>
                <p class="text-4xl font-bold text-green-600">#{{ $order->id }}</p>
            </div>

            <!-- Order Items List -->
            <div class="mb-8">
                <h3 class="text-xl font-medium text-gray-800 mb-4">Položky objednávky:</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    @php
                        $variant = $item->variant;
                        $colorData = $variant->color_data;
                    @endphp
                    <li class="py-4 flex justify-between items-start">
                        <div class="flex items-start">
                            @if($variant->hasMedia('variants'))
                                <img src="{{ $variant->getFirstMediaUrl('variants', 'thumb') }}"
                                     class="h-16 w-16 object-cover rounded mr-3">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $variant->product->name }}</h4>
                                <div class="mt-1 flex items-center flex-wrap gap-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                          style="background-color: {{ $colorData->hex_code }}; color: {{ $colorData->contrast_color }}">
                                        {{ $colorData->name }}
                                    </span>
                                    @if($variant->formatted_dimensions)
                                        <span class="text-xs text-gray-500">
                                            {{ $variant->formatted_dimensions }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    Množství: {{ $item->quantity }} × {{ number_format($item->price, 2) }} Kč
                                </p>
                            </div>
                        </div>
                        <span class="font-medium">
                            {{ number_format($item->price * $item->quantity, 2) }} Kč
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-4 mb-8">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Cena produktů:</span>
                    <span class="font-medium">
                        {{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }} Kč
                    </span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Doprava:</span>
                    <span class="font-medium">
                        @if($order->delivery_method === 'courier')
                            200 Kč
                        @else
                            0 Kč
                        @endif
                    </span>
                </div>
                <div class="flex justify-between py-3 border-t border-gray-200 mt-2">
                    <span class="font-bold">Celkem:</span>
                    <span class="text-green-600 font-bold">
                        {{ number_format($order->total, 2) }} Kč
                    </span>
                </div>
            </div>

            @if($order->payment_method !== 'cash_on_delivery')
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8">
                <h4 class="text-lg font-medium text-blue-800 mb-3">Platební instrukce:</h4>
                <div class="space-y-2 text-blue-700">
                    <p><span class="font-medium">Částka k úhradě:</span> {{ number_format($order->deposit_amount, 2) }} Kč</p>
                    <p><span class="font-medium">Banka:</span> Česká spořitelna</p>
                    <p><span class="font-medium">Číslo účtu:</span> 4753073093/0800</p>
                    <p><span class="font-medium">Příjemce:</span> Yurii Kolesnyk</p>
                    <p><span class="font-medium">Variabilní symbol:</span> {{ $order->variable_symbol }}</p>
                </div>
            </div>
            @endif

            <div class="text-center">
                <p class="text-lg text-gray-600 mb-6">V nejbližší době vás budeme kontaktovat k potvrzení objednávky.</p>

                <a href="{{ route('home') }}"
                   class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Zpět na hlavní stránku
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
