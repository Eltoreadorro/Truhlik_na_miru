@php
    use App\Models\Order;
@endphp

@extends('admin.layout')

@section('title', 'Detail objednávky #'.$order->id)

@section('content_header')
    @section('header_title', 'Objednávka #'.$order->id)
    @section('header_buttons')
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Zpět na seznam
        </a>
    @endsection
@stop

@section('admin_content')
<div class="row">
    <div class="col-lg-8">
        <div class="card card-primary card-outline">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-shopping-basket mr-2"></i>
                    Položky objednávky
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 40%">Produkt</th>
                                <th>Varianta</th>
                                <th class="text-center">Množství</th>
                                <th class="text-right">Cena/ks</th>
                                <th class="text-right">Celkem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->variant->getFirstMediaUrl('variants', 'thumb'))
                                        <img src="{{ $item->variant->getFirstMediaUrl('variants', 'thumb') }}"
                                            class="img-size-50 mr-3 img-circle"
                                            alt="{{ $item->variant->product->name }}">
                                        @endif
                                        <div>
                                            <strong>{{ $item->variant->product->name }}</strong>
                                            <div class="text-muted text-sm">
                                                {{ $item->variant->product->sku ?? '—' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->variant->color_data)
                                        <span class="color-badge mr-2"
                                            style="background-color: {{ $item->variant->color_data->hex_code }};
                                                    color: {{ $item->variant->color_data->contrast_color }};">
                                            {{ $item->variant->color_data->name }}
                                        </span>
                                        @endif
                                        {{ $item->variant->formatted_dimensions }}
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-right">{{ number_format($item->price, 2) }} Kč</td>
                                <td class="text-right">{{ number_format($item->price * $item->quantity, 2) }} Kč</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="4" class="text-right">Mezisoučet:</th>
                                <th class="text-right">{{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }} Kč</th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Doprava:</th>
                                <th class="text-right">{{ $order->delivery_method === 'courier' ? '200,00 Kč' : '0,00 Kč' }}</th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Celkem:</th>
                                <th class="text-right">{{ number_format($order->total, 2) }} Kč</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        @if($order->payments->count() > 0)
        <div class="card card-primary card-outline mt-4">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-receipt mr-2"></i>
                    Platby
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Datum</th>
                                <th>Částka</th>
                                <th>Způsob</th>
                                <th>Stav</th>
                                <th>VS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ number_format($payment->amount, 2) }} Kč</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</td>
                                <td>
                                    <span class="badge badge-{{ $payment->status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                    </span>
                                </td>
                                <td>{{ $payment->variable_symbol }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if($order->statusHistory->isNotEmpty())
        <div class="card card-primary card-outline mt-4">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-history mr-2"></i>
                    Historie stavů
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Datum</th>
                                <th>Stav</th>
                                <th>Poznámka</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->statusHistory as $record)
                            <tr>
                                <td>{{ $record->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ Order::statuses()[$record->status] ?? $record->status }}</td>
                                <td>{{ $record->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informace o objednávce
                </h3>
            </div>
            <div class="card-body">
                <form id="order-form" action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
    <label>Stav objednávky</label>
    <select name="status" class="form-control select2" id="order-status" style="width: 100%;">
        @foreach(Order::statuses() as $key => $status)
            <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label id="comment-label">Komentář prodejce</label>
    <textarea name="seller_comment" class="form-control" rows="3">{{ old('seller_comment', $order->seller_comment) }}</textarea>
    <small class="form-text text-muted" id="comment-hint">Interní poznámka k objednávce</small>
</div>

                    <div class="form-group">
                        <label>Stav platby</label>
                        <select name="payment_status" class="form-control" id="payment-status-select">
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Čeká na platbu</option>
                            <option value="partially_paid" {{ $order->payment_status == 'partially_paid' ? 'selected' : '' }}>Částečně zaplaceno</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Zaplaceno</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Vráceno</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sledovací číslo</label>
                        <input type="text" name="tracking_number" class="form-control" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Např. PPL123456789">
                    </div>

                    <div class="form-group">
                        <label>Předpokládané doručení</label>
                        <input type="date" name="estimated_delivery_date" class="form-control" value="{{ old('estimated_delivery_date', $order->estimated_delivery_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label>Zákazník</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $order->customer_name }}" readonly>
                            @if($order->email)
                            <div class="input-group-append">
                                <a href="mailto:{{ $order->email }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                            @endif
                            @if($order->phone)
                            <div class="input-group-append">
                                <a href="tel:{{ $order->phone }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-phone"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Doručovací adresa</label>
                        <textarea class="form-control" rows="3" readonly>{{ $order->delivery_method === 'courier' ? $order->address : 'Osobní odběr' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Způsob dopravy</label>
                        <input type="text" class="form-control" value="{{ $order->delivery_method === 'courier' ? 'Doručení poštou (+200 Kč)' : 'Osobní odběr' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Služba dopravy</label>
                        <select name="delivery_service" class="form-control">
                            <option value="">-- Vyberte --</option>
                            <option value="Česká pošta" {{ $order->delivery_service == 'Česká pošta' ? 'selected' : '' }}>Česká pošta</option>
                            <option value="PPL" {{ $order->delivery_service == 'PPL' ? 'selected' : '' }}>PPL</option>
                            <option value="Osobní odběr" {{ $order->delivery_service == 'Osobní odběr' ? 'selected' : '' }}>Osobní odběr</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Způsob platby</label>
                        <input type="text" class="form-control" value="{{ $order->payment_method === 'full_prepayment' ? 'Plná předplatba' : 'Částečná předplatba' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Poznámka</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Interní poznámka k objednávce...">{{ old('notes', $order->notes) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-default" target="_blank">
                            <i class="fas fa-file-pdf mr-1"></i> Faktura
                        </a>

                        <button type="submit" class="btn btn-primary" id="save-button">
                            <i class="fas fa-save mr-1"></i> Uložit změny
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Vytvořeno</small><br>
                        {{ $order->created_at->format('d.m.Y H:i') }}
                    </div>
                    <div class="col-6 text-right">
                        <small class="text-muted">Aktualizováno</small><br>
                        <span class="order-updated-at">{{ $order->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.cancellation-reason-wrapper {
    margin-top: 15px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 4px;
    border-left: 4px solid #dc3545;
    transition: all 0.3s ease;
}

.cancellation-reason-wrapper textarea {
    min-height: 100px;
    width: 100%;
    display: inline;
}

/* These classes will override any other styles */
.cancellation-reason-visible {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
}

.cancellation-reason-hidden {
    display: none !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('order-status');
    const commentLabel = document.getElementById('comment-label');
    const commentHint = document.getElementById('comment-hint');
    const commentField = document.querySelector('[name="seller_comment"]');

    function updateCommentField() {
        if (statusSelect.value === 'cancelled') {
            commentLabel.textContent = 'Důvod zrušení *';
            commentHint.textContent = 'Tento text bude zákazníkovi odeslán v e-mailu';
            commentField.required = true;
        } else {
            commentLabel.textContent = 'Komentář prodejce';
            commentHint.textContent = 'Interní poznámka k objednávce';
            commentField.required = false;
        }
    }

    statusSelect.addEventListener('change', updateCommentField);
    updateCommentField(); // Инициализация при загрузке
});
</script>
@endpush
