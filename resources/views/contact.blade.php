@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- contacts.blade.php -->
<div id="custom-order" class="mt-5">
    <h2 class="mb-4">Индивидуальный заказ</h2>
    <div class="row">
        <div class="col-md-6">
            <p>Оставьте свои контактные данные и описание желаемого горшка, наш мастер свяжется с вами для уточнения деталей.</p>

            <div class="mb-3">
                <h5>Контакты:</h5>
                <p><i class="bi bi-telephone"></i> +420 123 456 789</p>
                <p><i class="bi bi-envelope"></i> custom@vazoni.cz</p>
            </div>
        </div>
        <div class="col-md-6">
            <form action="{{ route('custom.order') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Ваше имя" required>
                </div>
                <div class="mb-3">
                    <input type="tel" name="phone" class="form-control" placeholder="Телефон" required>
                </div>
                <div class="mb-3">
                    <textarea name="details" class="form-control" rows="5"
                              placeholder="Опишите желаемые размеры, цвет и другие детали" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить запрос</button>
            </form>
        </div>
    </div>
</div>

    <h1>Контакты</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Наш адрес</h5>
                    <p>g s s s</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Телефон</h5>
                    <p>3203220302</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
