<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card auth-animate">
            <div class="auth-header text-center">
                <img src="{{ asset('storage/output-onlinepngtools-_1_.ico') }}" alt="Truhlik na Miru" class="auth-logo mx-auto">
                <h1 class="auth-title">Obnovení hesla</h1>
                <p class="opacity-90">Zašleme odkaz pro obnovení</p>
            </div>

            <div class="auth-body">
                <div class="mb-6 text-gray-600 text-center">
                    Zapomněli jste heslo? Zadejte svůj e-mail a my vám zašleme instrukce pro obnovení.
                </div>

                <x-auth-session-status class="mb-6 text-center" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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

                    <button type="submit" class="auth-btn btn-hover-anim">
                        <i class="fas fa-paper-plane mr-2"></i> Odeslat odkaz
                    </button>

                    <div class="auth-footer text-center">
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="fas fa-arrow-left mr-1"></i> Zpět k přihlášení
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
