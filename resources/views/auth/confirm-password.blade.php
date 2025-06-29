<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card auth-animate">
            <div class="auth-header text-center">
                <img src="{{ asset('storage/output-onlinepngtools-_1_.ico') }}" alt="Truhlik na Miru" class="auth-logo mx-auto">
                <h1 class="auth-title">Potvrzení</h1>
                <p class="opacity-90">Potvrďte své heslo</p>
            </div>

            <div class="auth-body">
                <div class="mb-6 text-gray-600 text-center">
                    Toto je zabezpečená oblast aplikace. Prosím, potvrďte své heslo před pokračováním.
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                    @csrf
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Heslo</label>
                        <input id="password" class="auth-input text-gray-800 bg-white"
                               type="password"
                               name="password"
                               required
                               placeholder="Vaše heslo">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                    </div>

                    <button type="submit" class="auth-btn btn-hover-anim">
                        <i class="fas fa-shield-alt mr-2"></i> Potvrdit
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
