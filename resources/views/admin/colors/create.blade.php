@extends('admin.layout')

@section('title', 'Přidat barvu')

@section('content_header')
    @section('header_title', 'Nová barva')
    @section('header_buttons')
        <a href="{{ route('admin.colors.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Zpět
        </a>
    @endsection
@stop

@section('admin_content')
    <form action="{{ route('admin.colors.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Název barvy*</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>HEX kód*</label>
                    <div class="input-group">
                        <input type="color" id="color-picker" value="#ffffff">
                        <input type="text" name="hex_code" class="form-control" placeholder="#ffffff" required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Uložit</button>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
    document.getElementById('color-picker').addEventListener('input', function() {
        document.querySelector('input[name="hex_code"]').value = this.value;
    });
</script>
@stop
