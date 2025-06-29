    @extends('layouts.app')

    @section('content')
    <div class="container mx-auto px-4 py-12 max-w-6xl" style="padding-top: 100px">

        <!-- Лого и описание компании -->
        <section class="mb-16 animate__animated animate__fadeIn">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/3 flex justify-center">
                    <img src="{{ asset('storage/products/logo-w-removebg-preview.png') }}" alt="Truhlik na Miru"
                        class="w-64 h-auto transition-all duration-500 hover:scale-105 hover:rotate-1">
                </div>
                <div class="md:w-2/3">
                    <h1 class="text-4xl font-bold mb-6 text-gray-800">Truhlik na Miru</h1>
                    <div class="space-y-4">
                        <p class="text-lg text-gray-600">
                            Naše značka se specializuje na originální truhlíky vyrobené z recyklovaného plastu. Každý kus je pečlivě ručně zhotoven a navržen tak, aby vydržel dlouhá léta a vynikal jedinečnou kombinací barev a moderního designu. Spojujeme udržitelnost, kreativitu a poctivé řemeslo v každém detailu.
                        </p>
                        <p class="text-gray-600">
                            Každý květináč je umělecké dílo vytvořené s láskou a pozorností k detailům.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Блок с инструкцией и формой -->
        <section id="custom-order" class="mb-20 bg-gradient-to-r from-gray-50 to-green-50 rounded-2xl p-8 shadow-lg animate__animated animate__fadeInUp">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Инструкция -->
                <div>
                    <h2 class="text-3xl font-bold mb-8 text-gray-800">Jak objednat individuální výrobek</h2>

                    <div class="space-y-6">
                        @foreach ([
                            ['icon' => 'fas fa-pen', 'title' => 'Popište svůj požadavek', 'text' => 'Uveďte požadované rozměry, barvu a designové detaily'],
                            ['icon' => 'fas fa-phone', 'title' => 'Zanechte kontakty', 'text' => 'Ozvěme se vám k potvrzení detailů'],
                            ['icon' => 'fas fa-cogs', 'title' => 'Výroba', 'text' => 'Standardní modely 3-5 dní, individuální od 7 dnů'],
                            ['icon' => 'fas fa-truck', 'title' => 'Doručení', 'text' => 'V Praze 1-2 dny, v ČR 2-3 pracovní dny']
                        ] as $step)
                            <div class="flex items-start gap-4 p-3 rounded-xl transition-all duration-300 hover:bg-white hover:shadow-md">
                                <div class="bg-green-100 p-3 rounded-full text-green-600 flex-shrink-0 hover:scale-110 transition-transform">
                                    <i class="{{ $step['icon'] }} fa-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg mb-1">{{ $step['title'] }}</h4>
                                    <p class="text-gray-600">{{ $step['text'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Форма -->
                <div>
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 animate__animated animate__fadeIn">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 animate__animated animate__fadeIn">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('contacts.send.custom-order') }}" method="POST" class="space-y-6" id="order-form" novalidate>
                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 mb-2 font-medium">Jméno *</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                                    value="{{ old('name') }}" placeholder="Např. Jan Novák">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1 animate__animated animate__fadeIn">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-gray-700 mb-2 font-medium">Email *</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                                    value="{{ old('email') }}" placeholder="např. jan.novak@email.cz">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1 animate__animated animate__fadeIn">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700 mb-2 font-medium">Telefon</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                                value="{{ old('phone') }}" placeholder="+420 123 456 789">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1 animate__animated animate__fadeIn">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="details" class="block text-gray-700 mb-2 font-medium">Popis požadavku *</label>
                            <textarea id="details" name="details" rows="5" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300"
                                placeholder="Např.:
    - Rozměry: 30x40 cm
    - Barva: bílá
    - Množství: 2 ks">{{ old('details') }}</textarea>
                            @error('details')
                                <p class="text-red-500 text-sm mt-1 animate__animated animate__fadeIn">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- @if (config('services.recaptcha.site_key'))
                            <div class="g-recaptcha mb-4" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @error('g-recaptcha-response')
                                <p class="text-red-500 text-sm mb-4 animate__animated animate__fadeIn">{{ $message }}</p>
                            @enderror
                        @endif --}}

                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg"
                                id="submit-btn">
                            Odeslat požadavek
                            <span class="submit-spinner hidden ml-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Контактная информация -->
        <section class="mb-16 animate__animated animate__fadeIn">
            <h2 class="text-3xl font-bold mb-12 text-center text-gray-800">Kontaktní informace</h2>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach ([
                    ['icon' => 'fas fa-map-marker-alt', 'title' => 'Adresa', 'items' => ['Sulice, Česká republika', 'Sulicka 42, 251 68']],
                    ['icon' => 'fas fa-phone-alt', 'title' => 'Kontakty', 'items' => ['<i class="fas fa-phone mr-2 text-green-500"></i> +420 606 912 403', '<i class="fas fa-envelope mr-2 text-green-500"></i> truhliknamiru@gmail.com']],
                    ['icon' => 'fas fa-clock', 'title' => 'Otevírací doba', 'items' => ['Po-Pá: 9:00 - 18:00', 'So-Ne: 10:00 - 15:00']]
                ] as $card)
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-2">
                        <div class="text-green-500 text-4xl mb-6 text-center hover:scale-110 transition-transform">
                            <i class="{{ $card['icon'] }}"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-center">{{ $card['title'] }}</h3>
                        <div class="space-y-2 text-center">
                            @foreach ($card['items'] as $item)
                                <p class="text-gray-600">{!! $item !!}</p>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Карта и фото магазина -->
        <section class="mb-16 animate__animated animate__fadeIn">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="rounded-xl overflow-hidden shadow-lg h-96">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d329.0266102453344!2d14.557399867420266!3d49.92385889999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470b8586cf0f504f%3A0xe6b1f7f7338f0b1b!2sSulice%2042%2C%20251%2068%20Sulice!5e1!3m2!1sru!2scz!4v1751206053549!5m2!1sru!2scz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="rounded-xl overflow-hidden shadow-lg h-96">
                    <img src="{{ asset('storage/products/20250608_132206.jpg') }}" alt="Náš obchod"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                </div>
            </div>
        </section>

<!-- Галерея -->
<section class="my-16 animate__animated animate__fadeIn">
    <h2 class="text-3xl font-bold mb-12 text-center text-gray-800">Naše práce</h2>

    <div id="gallery-container">
        @php
            $files = collect(Storage::disk('public')->files('gallery'))
                ->filter(fn($file) => preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file))
                ->sort()
                ->values();

            $totalImages = $files->count();
            $initialFiles = $files->slice(0, min(12, $totalImages));
        @endphp

        @foreach($initialFiles as $index => $file)
            @php
                $url = Storage::url($file);
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $imageSize = @getimagesize(public_path('storage/' . $file));
                $width = $imageSize[0] ?? 1;
                $height = $imageSize[1] ?? 1;
                $ratio = $width / $height;

                // Определяем размер карточки
                $sizeClass = 'size-1x1';
                if ($ratio > 1.5) {
                    $sizeClass = 'size-2x1';
                } elseif ($ratio < 0.67) {
                    $sizeClass = 'size-1x2';
                } elseif ($width > 2000 && $height > 2000) {
                    $sizeClass = 'size-2x2';
                }

                $globalPosition = $index + 1;
            @endphp
            <div class="gallery-item {{ $sizeClass }}"
                 data-global-pos="{{ $globalPosition }}">
                <a href="{{ $url }}" class="gallery-link" data-lightbox="gallery" data-title="{{ $filename }}" data-position="{{ $globalPosition }}">
                    <div class="aspect-container">
                        <img src="{{ $url }}"
                             alt="{{ $filename }}"
                             class="lazyload"
                             loading="lazy"
                             onload="this.style.opacity = 1">
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if($totalImages > 12)
        <div class="text-center mt-8">
            <button id="load-more-gallery"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg"
                    data-page="1">
                Zobrazit více <i class="fas fa-chevron-down ml-2"></i>
            </button>
        </div>
    @endif
</section>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90">
    <div class="absolute top-4 right-4 z-50">
        <button id="lightbox-close" class="text-white text-4xl hover:text-gray-300">&times;</button>
    </div>

    <div class="flex items-center justify-center h-full">
        <button id="lightbox-prev" class="absolute left-4 text-white text-4xl hover:text-gray-300 z-50 p-4 bg-black bg-opacity-50 rounded-full">
            &larr;
        </button>

        <div class="relative max-w-4xl w-full h-full flex items-center justify-center">
            <img id="lightbox-image" src="" alt="" class="max-h-full max-w-full object-contain transition-opacity duration-200">

            <div id="lightbox-counter" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-70 text-white px-4 py-2 rounded-full text-sm">
                1 z {{ $totalImages }}
            </div>
        </div>

        <button id="lightbox-next" class="absolute right-4 text-white text-4xl hover:text-gray-300 z-50 p-4 bg-black bg-opacity-50 rounded-full">
            &rarr;
        </button>
    </div>
</div>
    @endsection

    @section('styles')
<style>
    /* Основные стили галереи */
    #gallery-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 8px;
        grid-auto-rows: 150px;
        grid-auto-flow: dense;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .gallery-item:hover {
        transform: scale(1.02);
        box-shadow: 0 14px 28px rgba(0,0,0,0.15), 0 10px 10px rgba(0,0,0,0.12);
        z-index: 10;
    }

    .aspect-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .aspect-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    /* Классы для разных размеров карточек */
    .gallery-item.size-1x1 {
        grid-row: span 1;
        grid-column: span 1;
    }

    .gallery-item.size-2x1 {
        grid-row: span 1;
        grid-column: span 2;
    }

    .gallery-item.size-1x2 {
        grid-row: span 2;
        grid-column: span 1;
    }

    .gallery-item.size-2x2 {
        grid-row: span 2;
        grid-column: span 2;
    }

    /* Адаптация для планшетов */
    @media (min-width: 640px) {
        #gallery-container {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-auto-rows: 200px;
            gap: 10px;
        }
    }

    /* Адаптация для компьютеров */
    @media (min-width: 1024px) {
        #gallery-container {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-auto-rows: 250px;
            gap: 12px;
        }
    }

    /* Анимации */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Lightbox стили */
    #lightbox-modal {
        transition: opacity 0.3s ease;
    }

    #lightbox-image {
        transition: transform 0.3s ease;
        max-height: 90vh;
        max-width: 90vw;
        object-fit: contain;
    }
</style>
@endsection


   @section('scripts')
@if (config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== ГАЛЕРЕЯ ==========
    const galleryContainer = document.getElementById('gallery-container');
    const loadMoreBtn = document.getElementById('load-more-gallery');
    let galleryItems = Array.from(document.querySelectorAll('.gallery-item'));
    let currentLightboxIndex = 0;
    let totalImages = parseInt('{{ $totalImages }}') || 0;
    let currentPage = 1;
    const perPage = 10;

    if (loadMoreBtn && galleryContainer) {
        let isLoading = false;

        // Функция загрузки дополнительных изображений
        async function loadMoreGalleryItems() {
            if (isLoading || (currentPage * perPage) >= totalImages) return;

            isLoading = true;
            const originalBtnText = loadMoreBtn.innerHTML;
            loadMoreBtn.disabled = true;
            loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Načítání...';

            try {
                const response = await fetch(`/gallery/load-more?page=${currentPage + 1}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const { html, hasMore, nextPage, totalImages: newTotal } = await response.json();

                if (html) {
                    // Создаем временный контейнер для парсинга HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;

                    // Добавляем новые элементы с анимацией
                    const newItems = Array.from(tempDiv.querySelectorAll('.gallery-item'));
                    newItems.forEach((item, index) => {
                        item.style.opacity = '0';
                        item.style.animation = `fadeIn 0.5s ease-out ${0.1 * index}s forwards`;
                        galleryContainer.appendChild(item);
                    });

                    // Обновляем данные
                    galleryItems = Array.from(document.querySelectorAll('.gallery-item'));
                    currentPage = nextPage;
                    totalImages = newTotal || totalImages;

                    // Переинициализируем lightbox для новых изображений
                    initLightboxEventListeners();

                    // Скрываем кнопку если все загружено
                    if (!hasMore || (currentPage * perPage) >= totalImages) {
                        loadMoreBtn.remove();
                    }
                }
            } catch (error) {
                console.error('Chyba při načítání galerie:', error);
                loadMoreBtn.innerHTML = 'Chyba, zkuste znovu <i class="fas fa-redo ml-2"></i>';
                setTimeout(() => {
                    loadMoreBtn.innerHTML = originalBtnText;
                    loadMoreBtn.disabled = false;
                }, 2000);
            } finally {
                isLoading = false;
                if (loadMoreBtn && !loadMoreBtn.disabled) {
                    loadMoreBtn.innerHTML = originalBtnText;
                    loadMoreBtn.disabled = false;
                }
            }
        }

        // Обработчик клика на кнопку "Загрузить еще"
        loadMoreBtn.addEventListener('click', loadMoreGalleryItems);
    }

    // Инициализация обработчиков событий для lightbox
    function initLightboxEventListeners() {
        galleryItems = Array.from(document.querySelectorAll('.gallery-item'));

        galleryItems.forEach((item, index) => {
            const link = item.querySelector('a.gallery-link');
            if (link) {
                // Удаляем старые обработчики
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);

                // Обновляем data-position в соответствии с реальным индексом
                newLink.dataset.position = index + 1;

                // Добавляем новые обработчики
                newLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    openLightbox(index);
                });
            }
        });
    }

    // Функция открытия lightbox
    function openLightbox(index) {
        currentLightboxIndex = index;
        const item = galleryItems[currentLightboxIndex];
        const link = item.querySelector('a.gallery-link');

        if (!link) return;

        const imgUrl = link.href;
        const imgTitle = link.dataset.title || '';
        const position = link.dataset.position || currentLightboxIndex + 1;

        const lightboxModal = document.getElementById('lightbox-modal');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxCounter = document.getElementById('lightbox-counter');

        if (!lightboxModal || !lightboxImage || !lightboxCounter) return;

        lightboxImage.src = imgUrl;
        lightboxImage.alt = imgTitle;
        lightboxCounter.textContent = `${position} z ${totalImages}`;

        lightboxImage.onload = () => {
            lightboxImage.classList.remove('opacity-0');
        };

        lightboxModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Функция закрытия lightbox
    function closeLightbox() {
        const lightboxModal = document.getElementById('lightbox-modal');
        const lightboxImage = document.getElementById('lightbox-image');

        if (!lightboxModal || !lightboxImage) return;

        lightboxModal.classList.add('hidden');
        document.body.style.overflow = '';
        lightboxImage.classList.add('opacity-0');
    }

    // Функция навигации
    function navigate(direction) {
        currentLightboxIndex = (currentLightboxIndex + direction + galleryItems.length) % galleryItems.length;
        openLightbox(currentLightboxIndex);
    }

    // Инициализация lightbox
    function initLightbox() {
        // Создаем модальное окно lightbox, если его нет
        if (!document.getElementById('lightbox-modal')) {
            const lightboxHTML = `
                <div id="lightbox-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90">
                    <button id="lightbox-close" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 z-50">&times;</button>
                    <div class="flex items-center justify-center h-full">
                        <button id="lightbox-prev" class="absolute left-4 text-white text-4xl hover:text-gray-300 z-50 p-4 bg-black bg-opacity-50 rounded-full">&larr;</button>
                        <div class="relative max-w-4xl w-full h-full flex items-center justify-center p-4">
                            <img id="lightbox-image" src="" alt="" class="max-h-full max-w-full object-contain opacity-0 transition-opacity duration-300">
                            <div id="lightbox-counter" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-70 text-white px-4 py-2 rounded-full text-sm"></div>
                        </div>
                        <button id="lightbox-next" class="absolute right-4 text-white text-4xl hover:text-gray-300 z-50 p-4 bg-black bg-opacity-50 rounded-full">&rarr;</button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', lightboxHTML);
        }

        // Инициализация обработчиков событий
        initLightboxEventListeners();

        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxPrev = document.getElementById('lightbox-prev');
        const lightboxNext = document.getElementById('lightbox-next');

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxPrev) lightboxPrev.addEventListener('click', () => navigate(-1));
        if (lightboxNext) lightboxNext.addEventListener('click', () => navigate(1));

        // Навигация с клавиатуры
        document.addEventListener('keydown', (e) => {
            const lightboxModal = document.getElementById('lightbox-modal');
            if (!lightboxModal || lightboxModal.classList.contains('hidden')) return;

            switch(e.key) {
                case 'Escape': closeLightbox(); break;
                case 'ArrowLeft': navigate(-1); break;
                case 'ArrowRight': navigate(1); break;
            }
        });
    }

    // Инициализация lightbox при загрузке страницы
    initLightbox();

    // ========== ФОРМА ==========
    const form = document.getElementById('order-form');
    if (form) {
        form.addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            if (btn) {
                const spinner = btn.querySelector('.submit-spinner');
                btn.disabled = true;
                spinner?.classList.remove('hidden');
            }
        });
    }

    // ========== МАСКА ДЛЯ ТЕЛЕФОНА ==========
    if (typeof Inputmask !== 'undefined' && document.getElementById('phone')) {
        new Inputmask({
            mask: '+420 999 999 999',
            placeholder: '+420 ___ ___ ___',
            showMaskOnHover: false,
            clearIncomplete: true
        }).mask(document.getElementById('phone'));
    }

    // ========== LAZYLOAD ==========
    if (window.lazySizes) {
        lazySizes.init();
        lazySizes.cfg.loadMode = 1;
    }
});

document.querySelector('form[action="{{ route('subscribe') }}"]').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const response = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    const result = await response.json();
    alert(result.message);
});
</script>
@endsection
