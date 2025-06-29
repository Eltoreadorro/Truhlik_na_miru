<header class="bg-black text-white shadow-md fixed w-full z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Логотип -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('storage/output-onlinepngtools-_1_.ico') }}" alt="Truhlik na Miru" class="h-10 mr-2">
                    
                </a>
            </div>

            <!-- Мобильное меню (бургер) -->
            <div class="md:hidden flex items-center">
                <button id="mobileMenuButton" class="text-white focus:outline-none p-2">
                    <svg id="menuOpenIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="menuCloseIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Основное меню -->
            <nav class="hidden md:flex space-x-6">
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="nav-link relative group {{ request()->routeIs('home') ? 'text-accent-green' : 'text-white' }}">
                        Domů
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-accent-green transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link relative group {{ request()->routeIs('products.*') ? 'text-accent-green' : 'text-white' }}">
                        Produkty
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-accent-green transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('contacts') }}" class="nav-link relative group {{ request()->routeIs('contacts') ? 'text-accent-green' : 'text-white' }}">
                        Kontakt
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-accent-green transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <div class="border-l border-gray-600 pl-6 ml-2">
                            <a href="{{ route('admin.index') }}" class="nav-link relative group {{ request()->routeIs('admin.*') ? 'text-accent-green' : 'text-white' }}">
                                Admin
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-accent-green transition-all duration-300 group-hover:w-full"></span>
                            </a>
                        </div>
                    @endif
                @endauth
            </nav>

            <!-- Иконки -->
            <div class="hidden md:flex items-center space-x-6">
                <livewire:cart-icon />

                @auth
                    <div class="relative">
                        <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none group">
                            <span class="text-white group-hover:text-accent-green transition">{{ Auth::user()->name }}</span>
                            <i class="fas fa-user-circle text-xl text-white group-hover:text-accent-green transition"></i>
                        </button>

                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 divide-y divide-gray-100">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition">
                                    <i class="fas fa-user-edit mr-2"></i> Profil
                                </a>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100 transition">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Odhlásit se
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-accent-green transition flex items-center">
                        <span class="mr-2">Přihlásit se</span>
                        <i class="fas fa-sign-in-alt text-xl"></i>
                    </a>
                @endauth
            </div>
        </div>

        <!-- Мобильное меню (содержимое) -->
        <div id="mobileMenu" class="hidden md:hidden bg-gray-900 py-4 px-4 rounded-lg mt-2 shadow-lg transition-all duration-300 transform -translate-y-2 opacity-0">
            <div class="flex flex-col space-y-3">
                <!-- Основные пункты -->
                <div class="space-y-3">
                    <a href="{{ route('home') }}" class="block text-white hover:text-accent-green px-3 py-2 rounded-md transition flex items-center bg-gray-800 hover:bg-gray-700">
                        <i class="fas fa-home mr-3 w-5 text-center"></i> Domů
                    </a>
                    <a href="{{ route('products.index') }}" class="block text-white hover:text-accent-green px-3 py-2 rounded-md transition flex items-center bg-gray-800 hover:bg-gray-700">
                        <i class="fas fa-box-open mr-3 w-5 text-center"></i> Produkty
                    </a>
                    <a href="{{ route('contacts') }}" class="block text-white hover:text-accent-green px-3 py-2 rounded-md transition flex items-center bg-gray-800 hover:bg-gray-700">
                        <i class="fas fa-envelope mr-3 w-5 text-center"></i> Kontakt
                    </a>
                </div>

                @auth
                    <!-- Админка -->
                    @if(auth()->user()->hasRole('admin'))
                        <div class="pt-2">
                            <a href="{{ route('admin.index') }}" class="block text-white hover:text-accent-green px-3 py-2 rounded-md transition flex items-center bg-gray-800 hover:bg-gray-700">
                                <i class="fas fa-cog mr-3 w-5 text-center"></i> Admin
                            </a>
                        </div>
                    @endif

                    <!-- Профиль -->
                    <div class="pt-4 border-t border-gray-700">
                        <div class="space-y-3">
                            <a href="{{ route('profile.edit') }}" class="block text-white hover:text-accent-green px-3 py-2 rounded-md transition flex items-center bg-gray-800 hover:bg-gray-700">
                                <i class="fas fa-user-edit mr-3 w-5 text-center"></i> Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left text-white hover:text-accent-green px-3 py-2 rounded-md flex items-center bg-gray-800 hover:bg-gray-700 transition">
                                    <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> Odhlásit se
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Вход -->
                    <div class="pt-4 border-t border-gray-700">
                        <a href="{{ route('login') }}" class="block text-white hover:text-accent-green px-3 py-2 rounded-md transition flex items-center bg-gray-800 hover:bg-gray-700">
                            <i class="fas fa-sign-in-alt mr-3 w-5 text-center"></i> Přihlásit se
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Мобильное меню
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuOpenIcon = document.getElementById('menuOpenIcon');
    const menuCloseIcon = document.getElementById('menuCloseIcon');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isOpen = mobileMenu.classList.toggle('hidden');

            if (isOpen) {
                mobileMenu.classList.remove('translate-y-0', 'opacity-100');
                mobileMenu.classList.add('-translate-y-2', 'opacity-0');
                menuOpenIcon.style.display = 'block';
                menuCloseIcon.style.display = 'none';
            } else {
                mobileMenu.classList.remove('-translate-y-2', 'opacity-0');
                mobileMenu.classList.add('translate-y-0', 'opacity-100');
                menuOpenIcon.style.display = 'none';
                menuCloseIcon.style.display = 'block';
            }
        });
    }

    // Меню пользователя
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });

        // Закрытие при клике вне меню
        document.addEventListener('click', function(event) {
            if (!userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
});
</script>
