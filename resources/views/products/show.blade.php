@extends('layouts.app')

@section('content')
    <div class="container max-w-6xl mx-auto px-4 py-8 pt-20 mt-5">
        <div class="container max-w-6xl mx-auto px-2 py-1">
            <!-- Основная информация о продукте -->
            <div class="flex flex-col md:flex-row gap-8 mb-12">
                <!-- Галерея изображений -->
                <div class="md:w-1/2">
                    <!-- Главное изображение -->
                    <div class="mb-4 rounded-xl shadow-lg overflow-hidden relative bg-gray-100 flex items-center justify-center"
                         style="min-height: 400px; max-height: 600px;">
                        @if ($product->getFirstMediaUrl('main'))
                            <img src="{{ $product->getFirstMediaUrl('main') }}"
                                 class="max-h-full max-w-full object-scale-down"
                                 id="main-product-image"
                                 alt="{{ $product->name }}"
                                 style="object-position: bottom;">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-gray-400">Bez obrázku</span>
                            </div>
                        @endif

                        <!-- Навигация по галерее -->
                        @if($product->getMedia('gallery')->count() > 0)
                            <div class="absolute inset-0 flex items-center justify-between px-4 opacity-0 hover:opacity-100 transition-opacity">
                                <button class="gallery-prev bg-white/80 rounded-full p-2 z-10 hover:bg-white shadow">
                                    <i class="fas fa-chevron-left text-gray-800"></i>
                                </button>
                                <button class="gallery-next bg-white/80 rounded-full p-2 z-10 hover:bg-white shadow">
                                    <i class="fas fa-chevron-right text-gray-800"></i>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Миниатюры вариантов -->
                    <div class="flex flex-wrap gap-3 mt-4">
                        @foreach ($product->variants as $variant)
                            <button
                                class="variant-thumbnail p-1 border-2 rounded-lg transition-all duration-200 {{ $variant->id == $selectedVariant->id ? 'border-green-400 ring-2 ring-green-300' : 'border-transparent hover:border-green-400' }} relative"
                                data-variant-id="{{ $variant->id }}"
                                
                                data-price="{{ $variant->price }}"
                                data-height="{{ $variant->height }}"
                                data-width="{{ $variant->width }}"
                                data-color-name="{{ $variant->colorRelation->name ?? $variant->color }}"
                                data-color-hex="{{ $variant->colorRelation->hex_code ?? $variant->color }}"
                                data-stock="{{ $variant->stock }}">
                                @if ($variant->getFirstMediaUrl('variants') || $product->getFirstMediaUrl('main'))
                                    <img src="{{ $variant->getFirstMediaUrl('variants') ?? $product->getFirstMediaUrl('main') }}"
                                        class="w-16 h-16 object-cover rounded-md"
                                        alt="{{ $variant->colorRelation->name ?? $variant->color }}">
                                    <span
                                        class="absolute bottom-1 left-1 right-1 bg-black bg-opacity-70 text-white text-xs px-1 rounded whitespace-nowrap overflow-hidden text-ellipsis">
                                        {{ $variant->colorRelation->name ?? $variant->color }}
                                    </span>
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center relative">
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                        <span
                                            class="absolute bottom-1 left-1 right-1 bg-black bg-opacity-70 text-white text-xs px-1 rounded whitespace-nowrap overflow-hidden text-ellipsis">
                                            {{ $variant->colorRelation->name ?? $variant->color }}
                                        </span>
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Информация о товаре -->
                <div class="md:w-1/2">
                    <h1 class="text-3xl font-bold mb-2 text-gray-800">{{ $product->name }}</h1>
                    <p class="text-gray-600 mb-4">{{ $product->category->name }}</p>

                    <!-- Блок с ценой -->
                    <div class="bg-gradient-to-r from-green-50 to-gray-50 p-6 rounded-xl mb-6 border border-gray-100">
                        <h4 class="text-2xl font-bold text-green-600 mb-3" id="selected-variant-price">
                            {{ number_format($selectedVariant->price, 2) }} Kč
                        </h4>
                        <div class="text-gray-700 space-y-2">
                            <p><span class="font-medium">Rozměry:</span>
                                <span id="variant-dimensions">{{ $selectedVariant->formatted_dimensions ?? '-' }}</span>
                            </p>
                            <p><span class="font-medium">Barva:</span>
                                <span id="variant-color" style="background:{{ $selectedVariant->colorRelation->hex_code ?? $selectedVariant->color }};
                                      color:{{ App\Models\ProductVariant::getContrastColor($selectedVariant->colorRelation->hex_code ?? $selectedVariant->color) }};
                                      padding:2px 5px; border-radius:3px">
                                    {{ $selectedVariant->colorRelation->name ?? $selectedVariant->color }}
                                </span>
                            </p>
                            <p><span class="font-medium">Skladem:</span>
                                <span id="variant-stock">{{ $selectedVariant->stock }}</span> ks
                            </p>
                        </div>
                    </div>

                    <!-- Форма заказа -->
                    <form action="{{ route('cart.add', $selectedVariant->id) }}" method="POST" class="mb-8"
                        id="variant-form">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                <button type="button"
                                    class="quantity-minus px-4 py-2 bg-gray-100 hover:bg-gray-200 transition">-</button>
                                <input type="number" name="quantity" value="1" min="1"
                                    max="{{ $selectedVariant->stock }}"
                                    class="w-16 text-center border-0 focus:ring-2 focus:ring-green-300 quantity-input">
                                <button type="button"
                                    class="quantity-plus px-4 py-2 bg-gray-100 hover:bg-gray-200 transition">+</button>
                            </div>
                            <button type="submit"
                                class="flex-1 bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                <i class="fas fa-shopping-cart mr-2"></i> Přidat do košíku
                            </button>
                        </div>
                    </form>

                    <!-- Описание -->
                    <div class="prose max-w-none border-t pt-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Popis</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Похожие товары -->
        @if ($similarProducts->count() > 0)
            <div class="mb-12">
                <h3 class="text-2xl font-bold mb-6 text-gray-800">Podobné produkty</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($similarProducts as $similar)
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 border border-gray-100">
                            <a href="{{ route('products.show', $similar) }}" class="block overflow-hidden h-48">
                                @if ($similar->getFirstMediaUrl('main'))
                                    <img src="{{ $similar->getFirstMediaUrl('main') }}"
                                        class="w-full h-full object-cover transition duration-500 hover:scale-110"
                                        alt="{{ $similar->name }}">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <span class="text-gray-400">Bez obrázku</span>
                                    </div>
                                @endif
                            </a>
                            <div class="p-4">
                                <h5 class="font-bold text-lg mb-2">
                                    <a href="{{ route('products.show', $similar) }}"
                                        class="hover:text-green-600 transition">
                                        {{ $similar->name }}
                                    </a>
                                </h5>
                                <p class="text-gray-600 text-sm mb-3">{{ $similar->category->name }}</p>
                                <p class="font-bold text-gray-800">Od
                                    {{ number_format($similar->variants->min('price'), 2) }} Kč</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Индивидуальный заказ -->
        <div class="bg-gradient-to-r from-gray-50 to-green-50 p-6 rounded-xl border border-gray-200">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Potřebujete květináč individuálních rozměrů?</h3>
                    <p class="text-gray-700">Vyrobíme pro vás květináč jakýchkoli rozměrů a barev podle vašich přání.</p>
                </div>
                <a href="{{ route('contacts') }}#custom-order"
                    class="px-6 py-3 bg-white text-green-600 rounded-lg border border-green-600 hover:bg-green-600 hover:text-white transition">
                    Objednat individuálně
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Галерея изображений
    const gallery = {
        images: @json($product->getMedia('gallery')->map(fn($media) => $media->getUrl())),
        currentIndex: 0,
        mainImage: document.getElementById('main-product-image'),
        isTransitioning: false,
        transitionDuration: 300,

        init() {
            if (this.images.length > 0) {
                document.querySelector('.gallery-prev')?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.navigate('prev');
                });

                document.querySelector('.gallery-next')?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.navigate('next');
                });

                document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
                    thumb.addEventListener('click', () => {
                        const imageUrl = thumb.dataset.image;
                        this.changeImage(imageUrl);
                    });
                });
            }
        },

        navigate(direction) {
            if (this.isTransitioning) return;

            this.isTransitioning = true;
            this.currentIndex = direction === 'prev'
                ? (this.currentIndex - 1 + this.images.length) % this.images.length
                : (this.currentIndex + 1) % this.images.length;

            this.changeImage(this.images[this.currentIndex]);
        },

        changeImage(src) {
            this.mainImage.style.opacity = '0';

            setTimeout(() => {
                this.mainImage.src = src;
                this.mainImage.style.opacity = '1';

                setTimeout(() => {
                    this.isTransitioning = false;
                }, this.transitionDuration);
            }, this.transitionDuration);
        }
    };

    // Управление вариантами товара
    const variantManager = {
        init() {
            document.querySelectorAll('.variant-thumbnail').forEach(thumb => {
                thumb.addEventListener('click', () => {
                    this.handleVariantChange(thumb);
                });
            });
        },

        handleVariantChange(thumb) {
            // Удаляем активный класс у всех миниатюр
            document.querySelectorAll('.variant-thumbnail').forEach(item => {
                item.classList.remove('border-green-400', 'ring-2', 'ring-green-300');
            });

            // Добавляем активный класс к текущей миниатюре
            thumb.classList.add('border-green-400', 'ring-2', 'ring-green-300');

            // Обновляем основное изображение
            const mainImage = document.getElementById('main-product-image');
            if (thumb.dataset.image) {
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = thumb.dataset.image;
                    mainImage.style.opacity = '1';
                }, 150);
            }

            // Обновляем цену
            document.getElementById('selected-variant-price').textContent =
                parseFloat(thumb.dataset.price).toFixed(2) + ' Kč';

            // Обновляем информацию о варианте
            document.getElementById('variant-dimensions').textContent =
                thumb.dataset.width ? thumb.dataset.width + '×' + thumb.dataset.height + ' cm' : '-';

            const variantColor = document.getElementById('variant-color');
            variantColor.style.background = thumb.dataset.colorHex;
            variantColor.style.color = this.getContrastColor(thumb.dataset.colorHex);
            variantColor.textContent = thumb.dataset.colorName || thumb.dataset.colorHex;

            document.getElementById('variant-stock').textContent = thumb.dataset.stock;

            // Обновляем форму
            const form = document.getElementById('variant-form');
            form.action = '/cart/add/' + thumb.dataset.variantId;

            // Обновляем максимальное количество для заказа
            const quantityInput = document.querySelector('.quantity-input');
            quantityInput.max = thumb.dataset.stock;
            if (parseInt(quantityInput.value) > parseInt(thumb.dataset.stock)) {
                quantityInput.value = thumb.dataset.stock;
            }
        },

        getContrastColor(hexColor) {
            if (!hexColor?.startsWith('#')) return '#ffffff';

            hexColor = hexColor.replace('#', '');
            const r = parseInt(hexColor.substr(0, 2), 16);
            const g = parseInt(hexColor.substr(2, 2), 16);
            const b = parseInt(hexColor.substr(4, 2), 16);
            const brightness = (r * 299 + g * 587 + b * 114) / 1000;

            return brightness > 128 ? '#000000' : '#ffffff';
        }
    };

    // Управление количеством товара
    const quantityManager = {
        init() {
            document.querySelector('.quantity-plus')?.addEventListener('click', () => {
                this.handleQuantityChange('increase');
            });

            document.querySelector('.quantity-minus')?.addEventListener('click', () => {
                this.handleQuantityChange('decrease');
            });
        },

        handleQuantityChange(direction) {
            const input = document.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            const max = parseInt(input.max);

            if (direction === 'increase' && currentValue < max) {
                input.value = currentValue + 1;
            } else if (direction === 'decrease' && currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    };

    // Инициализация всех компонентов
    gallery.init();
    variantManager.init();
    quantityManager.init();
});
</script>
@endsection
