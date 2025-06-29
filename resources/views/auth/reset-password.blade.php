<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card auth-animate">
            <div class="auth-header text-center">
                <img src="{{ asset('storage/output-onlinepngtools-_1_.ico') }}" alt="Truhlik na Miru" class="auth-logo mx-auto">
                <h1 class="auth-title">Nové heslo</h1>
                <p class="opacity-90">Nastavte si nové heslo</p>
            </div>

            <div class="auth-body">
                <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="auth-form-group">
                        <label for="email" class="auth-label">E-mail</label>
                        <input id="email" class="auth-input text-gray-800 bg-white"
                               type="email"
                               name="email"
                               value="{{ old('email', $request->email) }}"
                               required
                               autofocus
                               placeholder="Váš e-mail">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Nové heslo</label>
                        <input id="password" class="auth-input text-gray-800 bg-white"
                               type="password"
                               name="password"
                               required
                               placeholder="Nové heslo">
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
                        <i class="fas fa-sync-alt mr-2"></i> Obnovit heslo
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
