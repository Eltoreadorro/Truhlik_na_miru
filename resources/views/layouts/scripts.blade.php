<!-- Alpine JS -->

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Livewire -->
@livewireScripts

<!-- Кастомные скрипты -->
<script>


document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('[x-on\\:click]');
    const menu = document.querySelector('[x-show]');

    if (menuButton && menu) {
        let isOpen = false;

        menuButton.addEventListener('click', () => {
            isOpen = !isOpen;
            menu.style.display = isOpen ? 'block' : 'none';
            // Анимации можно добавить через classList.toggle()
        });
    }
});

    // Анимация при скролле
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация элементов с анимацией
        const animateElements = () => {
            const elements = document.querySelectorAll('.scroll-animate');
            const windowHeight = window.innerHeight;

            elements.forEach(el => {
                const elementPosition = el.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementPosition < windowHeight - elementVisible) {
                    el.classList.add('animate__animated', 'animate__fadeInUp');
                }
            });
        };

        // Проверка при загрузке
        animateElements();

        // Проверка при скролле
        window.addEventListener('scroll', animateElements);

        // Анимация для кнопок
        const buttons = document.querySelectorAll('.btn-hover-anim');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('href');

                // Анимация нажатия
                this.classList.add('animate__animated', 'animate__pulse');

                // Переход после анимации
                setTimeout(() => {
                    window.location.href = target;
                }, 300);
            });
        });
    });

    // Обновление корзины
    document.addEventListener('livewire:load', function() {
        Livewire.on('cartUpdated', () => {
            const cartIcon = document.querySelector('.fa-shopping-cart');
            cartIcon.classList.add('animate__animated', 'animate__tada');
            setTimeout(() => {
                cartIcon.classList.remove('animate__animated', 'animate__tada');
            }, 1000);
        });
    });

    // В файле scripts.blade.php или в секции @section('scripts')
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация анимаций для топ-продуктов
    const topProducts = document.querySelectorAll('.top-product-card');
    topProducts.forEach(card => {
        // Запуск анимации с задержкой
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, parseFloat(card.style.animationDelay || '0') * 1000);
    });

    // Анимация при скролле для обычных карточек
    const animateProductCards = () => {
        const cards = document.querySelectorAll('.product-card:not(.animated)');
        const windowHeight = window.innerHeight;

        cards.forEach(card => {
            const cardPosition = card.getBoundingClientRect().top;

            if (cardPosition < windowHeight - 100) {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                card.classList.add('animated');
            }
        });
    };

    // Запускаем при загрузке и при скролле
    animateProductCards();
    window.addEventListener('scroll', animateProductCards);

    // Эффект волны для кнопок
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-wave')) {
            const btn = e.target.closest('.btn-wave');
            const ripple = document.createElement('span');
            ripple.classList.add('btn-wave-effect');

            // Создаем эффект волны
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 1000);
        }
    });
    
});

document.querySelector('form[action="{{ route('subscribe') }}"]').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const button = form.querySelector('button[type="submit"]');
    const buttonHtml = button.innerHTML;

    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok) {
            // Успешная подписка
            form.reset();
            showAlert(data.message, 'success');
        } else {
            // Ошибка валидации
            showAlert(data.message || data.errors.email[0], 'error');
        }
    } catch (error) {
        showAlert('Došlo k chybě při odesílání', 'error');
    } finally {
        button.disabled = false;
        button.innerHTML = buttonHtml;
    }
});

function showAlert(message, type) {
    const alert = document.createElement('div');
    alert.className = `mb-4 p-2 rounded ${type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;
    alert.textContent = message;

    const form = document.querySelector('form[action="{{ route('subscribe') }}"]');
    form.insertBefore(alert, form.firstChild);

    setTimeout(() => alert.remove(), 5000);
}
</script>

@stack('scripts')
