    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Truhlik na Miru')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Кастомные стили -->
    <style>
        :root {
        --black: #121212;
        --white: #ffffff;
        --accent-green: #4CAF50;
        --accent-red: #F44336;
        --accent-yellow: #FFC107;
        --accent-blue: #2196F3;
        }

        body {
        font-family: 'Roboto', sans-serif;
        /* padding-top: 70px; Для фиксированного хедера */
        }

        .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8fafc;
        /* padding: 2rem; */
        }

        .auth-container {
        width: 100%;
        max-width: 800px; /* Увеличенная ширина */
        background: white;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        }

        .auth-header {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        padding: 2.5rem;
        text-align: center;
        color: white;
        }

        .auth-logo {
        height: 70px;
        margin-bottom: 1.5rem;
        }

        .auth-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.75rem 0;
        }

        .auth-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        }

        .auth-body {
        padding: 2rem;
        }

        .auth-form-group {
        margin-bottom: 2rem;
        }

        .auth-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: #374151;
        font-size: 1.1rem;
        }

        .auth-input {
        width: 100%;
        padding: 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        }

        .auth-input:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 5px rgba(76, 175, 80, 0.2);
        outline: none;
        }

        .auth-btn {
        width: 100%;
        padding: 1.25rem;
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
        }

        .auth-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
        }

        .auth-footer {
        text-align: center;
        margin-top: 2.5rem;
        color: #6b7280;
        font-size: 1.1rem;
        }

        .auth-link {
        color: #4CAF50;
        font-weight: 800;
        transition: all 0.2s ease;
        font-size: 1.1rem;
        }

        .auth-link:hover {
        color: #2E7D32;
        text-decoration: underline;
        }

        /* Анимации */
        @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
        }

        .auth-animate {
        animation: fadeInUp 0.7s ease-out forwards;
        }

        .product-card {
        /* opacity: 0; */
        transform: translateY(10px);
        transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .product-card.loaded {
        opacity: 1;
        transform: translateY(0);
        }

        .back-button {
        transition: all 0.3s ease;
        }

        .back-button:hover {
        transform: translateX(-5px);
        }

        .nav-link {
        position: relative;
        padding-bottom: 4px;
        }

        .nav-link:hover::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--accent-green);
        animation: underlineGrow 0.3s ease-out forwards;
        }


        @keyframes underlineGrow {
        from { width: 0; }
        to { width: 100%; }
        }

        .text-accent-green {
        color: var(--accent-green);
        }

        .bg-accent-green {
        background-color: var(--accent-green);
        }

        .transition {
        transition: all 0.3s ease;
        }

        /* Анимация появления элементов */
        [x-cloak] { display: none !important; }

        /* Анимация для карточек товаров */
        .product-card {
        transition: all 0.3s ease;
        }

        .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Анимация кнопок */
        .btn-hover-anim {
        position: relative;
        overflow: hidden;
        }

        .btn-hover-anim::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255,255,255,0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
        }

        .btn-hover-anim:hover::after {
        animation: ripple 1s ease-out;
        }

        @keyframes ripple {
        0% {
        transform: scale(0, 0);
        opacity: 1;
        }
        100% {
        transform: scale(20, 20);
        opacity: 0;
        }
        }
        /* Анимация для топ-3 горшков */
        .top-product-card {
        animation: fadeInUp 0.8s ease-out forwards;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        /* Анимация для обычных карточек */
        .product-card {
        animation: fadeInUp 0.6s ease-out forwards;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        }

        /* Эффект волны для кнопок */
        .btn-wave::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255,255,255,0.4);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
        }

        .btn-wave:hover::after {
        animation: ripple 1s ease-out;
        }

        /* Ключевые кадры анимаций */
        @keyframes fadeInUp {
        from {
        opacity: 0;
        transform: translateY(30px);
        }
        to {
        opacity: 1;
        transform: translateY(0);
        }
        }

        @keyframes ripple {
        0% {
        transform: scale(0, 0);
        opacity: 1;
        }
        20% {
        transform: scale(25, 25);
        opacity: 1;
        }
        100% {
        opacity: 0;
        transform: scale(40, 40);
        }
        }

        /* Эффект параллакса */
        .parallax-container {
        perspective: 1000px;
        }

        .parallax-image {
        transition: transform 0.5s ease-out;
        }

        /* Эффект наведения для карточек */
        .product-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }

        /* Модальное окно - минимально рабочий вариант */
        /* Модальное окно галереи */
        .gallery-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.9);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
        }

        .gallery-modal.show {
        display: flex;
        opacity: 1;
        }

        .gallery-modal .modal-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        width: 100%;
        }

        .modal-image {
        max-width: 100%;
        max-height: 80vh;
        display: block;
        margin: 0 auto;
        transition: opacity 0.3s ease;
        }

        .modal-close {
        position: absolute;
        top: -360px;
        right: 20px;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: all 0.3s ease;
        }

        .modal-close:hover {
        background: rgba(76, 175, 80, 0.8);
        transform: scale(1.1);
        }

        .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        transition: all 0.3s ease;
        }

        .modal-nav:hover {
        background: rgba(76, 175, 80, 0.8);
        transform: translateY(-50%) scale(1.1);
        }

        .modal-prev {
        left: 20px;
        }

        .modal-next {
        right: 20px;
        }

        /* Для body при открытом модальном окне */
        body.modal-open {
        overflow: hidden;
        }

        /* Стили для профиля */
        .btn-primary {
        background-color: #4CAF50;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        }

        .btn-primary:hover {
        background-color: #3e8e41;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-warning {
        background-color: #FFC107;
        color: #212529;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        }

        .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-danger {
        background-color: #F44336;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        }

        .btn-danger:hover {
        background-color: #d32f2f;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Анимации для карточек */
        .animate__animated {
        opacity: 0;
        animation-fill-mode: forwards;
        }

        @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
        }

        .animate__fadeIn {
        animation-name: fadeIn;
        animation-duration: 0.5s;
        }

        /* Градиентные заголовки */
        .card-header-gradient {
        background: linear-gradient(135deg, var(--start-color), var(--end-color));
        color: white;
        }

        /* Формы */
        .form-group {
        margin-bottom: 1.5rem;
        }

        .form-control {
        transition: all 0.3s ease;
        }

        .form-control:focus {
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
        }

        .border-red-500 {
        border-color: #F44336;
        }

        .text-red-500 {
        color: #F44336;
        }


        /* Стили для главного изображения */
        #main-product-image {
        max-height: 80vh;
        width: auto;
        max-width: 100%;
        object-fit: contain;
        object-position: bottom;
        margin: 0 auto;
        }

        /* Контейнер для изображения */
        .product-image-container {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        background: #f5f5f5;
        min-height: 400px;
        max-height: 600px;
        overflow: hidden;
        }

        /* Адаптация для мобильных */
        @media (max-width: 768px) {
        .product-image-container {
        min-height: 300px;
        max-height: 400px;
        }

        #main-product-image {
        max-height: 60vh;
        }
        }

        /* Плавные переходы */
        .gallery-transition {
        transition: opacity 0.3s ease, transform 0.3s ease;
        }


        </style>

        @livewireStyles
        @stack('styles')
