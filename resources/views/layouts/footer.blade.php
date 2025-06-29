<footer class="bg-black text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8" x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 300)">
            <!-- Kontakty -->
            <div x-show="animate" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h3 class="text-xl font-bold mb-4 border-b-2 border-accent-green pb-2 inline-block">Kontakty</h3>
                <ul class="space-y-3">
                    <li class="flex items-start hover:text-accent-green transition transform hover:translate-x-1">
                        <i class="fas fa-phone-alt mt-1 mr-2 text-accent-green"></i>
                        <a href="tel:+420606912403">+420 606 912 403</a>
                    </li>
                    <li class="flex items-start hover:text-accent-green transition transform hover:translate-x-1">
                        <i class="fas fa-envelope mt-1 mr-2 text-accent-green"></i>
                        <a href="mailto:info@truhliknamiru.cz">truhliknamiru@gmail.com</a>
                    </li>
                    <li class="flex items-start hover:text-accent-green transition transform hover:translate-x-1">
                        <i class="fas fa-clock mt-1 mr-2 text-accent-green"></i>
                        Po-Pá: 9:00 - 18:00
                    </li>
                </ul>
            </div>

            <!-- Menu -->
            <div x-show="animate" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h3 class="text-xl font-bold mb-4 border-b-2 border-accent-green pb-2 inline-block">Menu</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="hover:text-accent-green transition transform hover:translate-x-1 block">Domů</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-accent-green transition transform hover:translate-x-1 block">Produkty</a></li>
                    <li><a href="{{ route('contacts') }}" class="hover:text-accent-green transition transform hover:translate-x-1 block">Kontakt</a></li>
                </ul>
            </div>

            <!-- Informace -->
            <div x-show="animate" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h3 class="text-xl font-bold mb-4 border-b-2 border-accent-green pb-2 inline-block">Informace</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('page.delivery') }}" class="hover:text-accent-green transition transform hover:translate-x-1 block">Doprava</a></li>
                    <li><a href="{{ route('page.returns') }}" class="hover:text-accent-green transition transform hover:translate-x-1 block">Vrácení zboží</a></li>
                    <li><a href="{{ route('page.terms') }}" class="hover:text-accent-green transition transform hover:translate-x-1 block">Obchodní podmínky</a></li>
                    <li><a href="{{ route('page.privacy') }}" class="hover:text-accent-green transition transform hover:translate-x-1 block">Ochrana osobních údajů</a></li>
                </ul>
            </div>

            <!-- Odběr novinek -->
            <div x-show="animate" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                <h3 class="text-xl font-bold mb-4 border-b-2 border-accent-green pb-2 inline-block">Odběr novinek</h3>
                <form action="{{ route('subscribe') }}" method="POST" class="mb-6">
    @csrf
    @if (session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->has('email'))
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">
            {{ $errors->first('email') }}
        </div>
    @endif
    <div class="flex shadow-lg rounded overflow-hidden transform hover:scale-105 transition duration-300">
        <input
            type="email"
            name="email"
            placeholder="Váš email"
            class="px-4 py-2 w-full focus:outline-none text-gray-900"
            required
            value="{{ old('email') }}"
        >
        <button
            type="submit"
            class="bg-accent-green text-white px-4 py-2 hover:bg-green-600 transition"
        >
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</form>

                <div class="flex space-x-4">
                    <a href="https://x.com/Truhlik_na_miru?t=E3xu7-Qv6VESM9ZIkBJEsA&s=08" class="text-white hover:text-accent-green transition text-xl transform hover:scale-125">
                        <i class="fab fa-twitter-f"></i>
                    </a>
                    <a href="https://www.instagram.com/truhlik_na_miru?igsh=Nmg0ZThqOXl4N3dl" class="text-white hover:text-accent-green transition text-xl transform hover:scale-125">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center" x-show="animate" x-transition:enter="transition ease-out duration-500 delay-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <p>&copy; {{ date('Y') }} Truhlik na Miru. Všechna práva vyhrazena.</p>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ route('subscribe') }}"]');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const buttonOriginal = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // Успех
                    const alert = document.createElement('div');
                    alert.className = 'mb-4 p-2 bg-green-100 text-green-700 rounded';
                    alert.textContent = data.message;
                    form.insertBefore(alert, form.firstChild);
                    form.reset();
                } else if (data.errors) {
                    // Ошибка
                    const alert = document.createElement('div');
                    alert.className = 'mb-4 p-2 bg-red-100 text-red-700 rounded';
                    alert.textContent = data.errors.email[0];
                    form.insertBefore(alert, form.firstChild);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = buttonOriginal;

                // Автоматическое скрытие сообщений через 5 секунд
                setTimeout(() => {
                    const alerts = form.querySelectorAll('div[class*="bg-"]');
                    alerts.forEach(alert => alert.remove());
                }, 5000);
            });
        });
    }
});
</script>
</footer>
