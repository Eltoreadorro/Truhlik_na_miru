<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card auth-animate">
            <div class="auth-header">
                <img src="{{ asset('storage/output-onlinepngtools-_1_.ico') }}" alt="Truhlik na Miru" class="auth-logo mx-auto">

                <h1 class="auth-title">Vítejte</h1>
                <p class="opacity-90">Přihlaste se ke svému účtu</p>
            </div>

            <div class="auth-body">
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div class="auth-form-group">
                        <label for="email" class="auth-label">E-mail</label>
                        <input id="email" class="auth-input text-gray-800 bg-white"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
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

                    <div class="flex items-center justify-between mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="h-5 w-5 text-green-600 rounded border-gray-300 focus:ring-green-500" name="remember">
                            <span class="ml-2 text-gray-700">Zapamatovat si mě</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="auth-link text-sm">
                            Zapomněli jste heslo?
                        </a>
                    </div>

                    <button type="submit" class="auth-btn btn-hover-anim">
                        <i class="fas fa-sign-in-alt mr-2"></i> Přihlásit se
                    </button>

                    <div class="auth-footer">
                        Nemáte ještě účet?
                        <a href="{{ route('register') }}" class="auth-link">Zaregistrujte se</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
