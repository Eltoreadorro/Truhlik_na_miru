@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Stav objednávky #{{ $order->id }}</h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <h4 class="alert-heading">Dobrý den, {{ $order->customer_name }}!</h4>
                        <hr>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge
                                @switch($order->status)
                                    @case('new') bg-secondary @break
                                    @case('processing') bg-info @break
                                    @case('ready') bg-warning text-dark @break
                                    @case('shipped') bg-primary @break
                                    @case('delivered') bg-success @break
                                    @case('cancelled') bg-danger @break
                                @endswitch
                                me-2 p-2">
                                {{ $order->status_text }}
                            </span>
                            <span>Aktuální stav vaší objednávky</span>
                        </div>

                        @if($order->tracking_number)
                            <div class="mb-3">
                                <strong>Sledovací číslo:</strong>
                                <span class="font-monospace">{{ $order->tracking_number }}</span>
                            </div>
                        @endif

                        @if($order->estimated_delivery_date)
                            <div class="mb-3">
                                <strong>Předpokládané doručení:</strong>
                                {{ $order->estimated_delivery_date->format('d.m.Y') }}
                            </div>
                        @endif

                        @if($order->delivery_service)
                            <div class="mb-3">
                                <strong>Dopravní služba:</strong>
                                {{ $order->delivery_service }}
                            </div>
                        @endif
                    </div>

                    <div class="timeline">
                        @foreach($order->status_history as $history)
                            <div class="timeline-item">
                                <div class="timeline-badge
                                    @if($history->is_current) bg-primary @else bg-light text-dark @endif">
                                </div>
                                <div class="timeline-content">
                                    <h6>{{ $history->status_text }}</h6>
                                    <small class="text-muted">
                                        {{ $history->created_at->format('d.m.Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i> Zpět na obchod
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
        border-left: 2px solid #dee2e6;
        margin-left: 1rem;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .timeline-badge {
        position: absolute;
        left: -1.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        transform: translateX(-50%);
    }
    .timeline-content {
        padding-left: 1rem;
    }
</style>
@endsection
