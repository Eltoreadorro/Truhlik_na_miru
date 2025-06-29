<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Název*</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
    </div>

    <div class="form-group">
        <label>Popis</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-group">
        <label>Kategorie*</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Hlavní obrázek</label>
        <input type="file" name="image" class="form-control-file">
        @if($product->getFirstMediaUrl('products'))
            <img src="{{ $product->getFirstMediaUrl('products') }}" width="100" class="mt-2">
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Aktualizovat</button>
</form>
