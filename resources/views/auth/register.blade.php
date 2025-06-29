<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card auth-animate">
            <div class="auth-header text-center">
                <img src="{{ asset('storage/output-onlinepngtools-_1_.ico') }}" alt="Truhlik na Miru" class="auth-logo mx-auto">
                <h1 class="auth-title">Vytvořit účet</h1>
                <p class="opacity-90">Přidejte se k nám</p>
            </div>

            <div class="auth-body">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div class="auth-form-group">
                        <label for="name" class="auth-label">Jméno</label>
                        <input id="name" class="auth-input text-gray-800 bg-white"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               placeholder="Vaše jméno">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
                    </div>

                    <div class="auth-form-group">
                        <label for="email" class="auth-label">E-mail</label>
                        <input id="email" class="auth-input text-gray-800 bg-white"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="Váš e-mail">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Heslo</label>
                        <input id="password" class="auth-input text-gray-800 bg-white"
                               type="password"
                               name="password"
                               required
                               placeholder="Vaše heslo">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                    </div>

                    <div class="auth-form-group">
                        <label for="password_confirmation" class="auth-label">Potvrzení hesla</label>
                        <input id="password_confirmation" class="auth-input text-gray-800 bg-white"
                               type="password"
                               name="password_confirmation"
                               required
                               placeholder="Zopakujte heslo">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
                    </div>

                    <button type="submit" class="auth-btn btn-hover-anim">
                        <i class="fas fa-user-plus mr-2"></i> Zaregistrovat se
                    </button>

                    <div class="auth-footer">
                        Již máte účet?
                        <a href="{{ route('login') }}" class="auth-link">Přihlaste se</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
