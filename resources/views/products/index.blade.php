@extends('layouts.app')

@section('content')
<div class="container py-8 mx-auto px-4 pt-20">

    <!-- Топ-3 продукта -->
    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-center scroll-animate">Top produkty</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($topVariants as $index => $variant)
<div class="top-product-card bg-gray-50 rounded-xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-md"
     style="opacity: 0; transform: translateY(50px); animation-delay: {{ $index * 0.2 }}s">
    <div class="relative h-64 overflow-hidden">
        <img src="{{ $variant->product->getFirstMediaUrl('main') ?? asset('img/no-image.png') }}"
     alt="{{ $variant->product->name }}"
     class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-xl font-bold text-white">{{ $variant->product->name }}</h3>
            @if($variant->color)
                <p class="text-accent-green font-medium">
                    <span style="background:{{ $variant->colorData->hex_code }};
                          color:{{ $variant->colorData->contrast_color }};
                          padding:2px 5px; border-radius:3px">
                        {{ $variant->colorData->name }}
                    </span>
                </p>
            @endif
        </div>
    </div>
    <div class="p-4">
        <p class="text-gray-600 mb-3">{{ $variant->product->category->name }}</p>
        <div class="flex justify-between items-center">
            <span class="text-xl font-bold">{{ $variant->formatted_price }}</span>
            <a href="{{ route('products.show', $variant->product) }}"
               class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition text-sm transform hover:-translate-y-1">
                Detail
            </a>
        </div>
    </div>
</div>
@endforeach
        </div>
    </section>

    <!-- Информация о доставке -->
    <section class="bg-gray-100 rounded-xl p-6 mb-12">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-accent-green text-4xl mb-3">
                    <i class="fas fa-truck"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Rychlé doručení</h3>
                <p>Praha - 1-2 dny, celá ČR - 2-3 pracovní dny</p>
            </div>
            <div class="text-center">
                <div class="text-accent-green text-4xl mb-3">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Výroba</h3>
                <p>Standardní modely - 3-5 dní, individuální - od 7 dnů</p>
            </div>
            <div class="text-center">
                <div class="text-accent-green text-4xl mb-3">
                    <i class="fas fa-palette"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Barvy</h3>
                <p>Více než 10 barevných variant na výběr</p>
            </div>
        </div>
    </section>

    <!-- Фільтри та каталог -->
    <section class="mb-16">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h2 class="text-2xl font-bold mb-4 md:mb-0">Katalog produktů</h2>

            <!-- Фільтр категорій -->
            <div class="flex space-x-4">
                <div class="relative">
                    <select id="category-filter" class="appearance-none bg-white border border-gray-300 rounded-md pl-4 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-accent-green text-sm">
                        <option value="">Všechny kategorie</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Контейнер продуктів -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="products-container">
            @include('products.load-more')
        </div>

        <!-- Кнопка "Завантажити ще" -->
        @if($products->hasMorePages())
        <div class="text-center mt-8">
            <button id="load-more-btn" class="bg-accent-green text-white px-6 py-3 rounded-md hover:bg-green-600 transition text-sm"
                    data-url="{{ $products->nextPageUrl() }}"
                    data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i> Načítání...">
                Načíst další
            </button>
        </div>
        @endif
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Анимация появления элементов
    const animateElements = () => {
        const elements = document.querySelectorAll('.product-card, .top-product-card');
        elements.forEach(el => {
            const delay = el.style.animationDelay || '0s';
            el.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        });
    };

    // Запуск анимации при загрузке
    setTimeout(animateElements, 100);

    // Загрузка дополнительных товаров (AJAX)
    const loadMoreProducts = () => {
        const btn = document.getElementById('load-more-btn');
        if (!btn) return;

        btn.addEventListener('click', function() {
            const originalText = btn.innerHTML;
            btn.innerHTML = btn.dataset.loadingText;
            btn.disabled = true;

            const url = new URL(btn.dataset.url);
            const categoryId = document.getElementById('category-filter')?.value;

            if (categoryId) {
                url.searchParams.set('category', categoryId);
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                if (html) {
                    const container = document.getElementById('products-container');
                    container.insertAdjacentHTML('beforeend', html);

                    // Обновляем URL для следующей загрузки
                    const nextPage = parseInt(url.searchParams.get('page') || 1) + 1;
                    url.searchParams.set('page', nextPage);
                    btn.dataset.url = url.toString();

                    // Анимация новых элементов
                    setTimeout(animateElements, 50);

                    // Если больше нет страниц, скрываем кнопку
                    if (!html.includes('load-more-btn')) {
                        btn.remove();
                    } else {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                }
            })
            .catch(() => {
                btn.innerHTML = 'Chyba, zkuste znovu';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);
            });
        });
    };

    // Фильтрация по категориям (AJAX без перезагрузки страницы)
    const setupCategoryFilter = () => {
        const filter = document.getElementById('category-filter');
        if (!filter) return;

        filter.addEventListener('change', function() {
            const categoryId = this.value;
            const url = new URL('{{ route("products.index") }}');

            if (categoryId) {
                url.searchParams.set('category', categoryId);
            }

            // Показываем индикатор загрузки
            const container = document.getElementById('products-container');
            container.innerHTML = '<div class="col-span-full text-center py-10"><i class="fas fa-spinner fa-spin text-3xl text-accent-green"></i></div>';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                setTimeout(animateElements, 50);

                // Обновляем URL в браузере без перезагрузки страницы
                window.history.pushState({}, '', url.toString());
            })
            .catch(() => {
                container.innerHTML = '<div class="col-span-full text-center py-10 text-red-500">Chyba při načítání produktů</div>';
            });
        });
    };

    loadMoreProducts();
    setupCategoryFilter();
});
</script>
@endsection
