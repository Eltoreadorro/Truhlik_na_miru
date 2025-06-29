@extends('admin.layout')

@section('title', 'Upravit objednávku #'.$order->id)

@section('content_header')
    @section('header_title', 'Upravit objednávku #'.$order->id)
    @section('header_buttons')
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Zpět na seznam
        </a>
    @endsection
@stop

@section('admin_content')
    <div class="card card-primary card-outline">
        <div class="card-body">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Скопируйте содержимое из show.blade.php начиная с формы -->
                @include('admin.orders._form', ['order' => $order])

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-default">
                        <i class="fas fa-times mr-1"></i> Zrušit
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Uložit změny
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
