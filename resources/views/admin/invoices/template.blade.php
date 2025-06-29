@extends('layouts.app')

@section('styles')
<style>
    .order-status {
        font-weight: 600;
    }
    .status-new { color: #3b82f6; }
    .status-processing { color: #f59e0b; }
    .status-shipped { color: #6366f1; }
    .status-delivered { color: #10b981; }
    .status-cancelled { color: #ef4444; }
</style>
@endsection

@section('content')
<div class="container py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h1 class="text-xl font-semibold">Objednávka #{{ $order->id }}</h1>
            </div>

            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-medium mb-2">Stav objednávky</h2>
                    <div class="flex items-center">
                        <span class="order-status status-{{ $order->status }} mr-2">
                            {{ $order->status_text }}
                        </span>
                        @if($order->payment_status !== 'paid')
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded ml-2">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                        @endif
                    </div>
                </div>

                @if($order->tracking_number)
                <div class="mb-6">
                    <h2 class="text-lg font-medium mb-2">Sledování zásilky</h2>
                    <p class="mb-2">
                        <span class="font-medium">Sledovací číslo:</span>
                        {{ $order->tracking_number }}
                    </p>
                    @if($order->delivery_service)
                    <p>
                        <span class="font-medium">Dopravce:</span>
                        {{ $order->delivery_service }}
                    </p>
                    @endif
                </div>
                @endif

                <a href="{{ url('/') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Zpět do obchodu
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
