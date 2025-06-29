<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card auth-animate">
            <div class="auth-header text-center">
                <img src="{{ asset('storage/output-onlinepngtools-_1_.ico') }}" alt="Truhlik na Miru" class="auth-logo mx-auto">
                <h1 class="auth-title">Ověření e-mailu</h1>
                <p class="opacity-90">Zkontrolujte svou e-mailovou schránku</p>
            </div>

            <div class="auth-body">
                <div class="mb-6 text-gray-600 text-center">
                    Děkujeme za registraci! Než začnete, potvrďte svůj e-mail kliknutím na odkaz, který jsme vám zaslali.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 text-green-600 text-center">
                        Nový ověřovací odkaz byl odeslán na váš e-mail.
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="auth-btn btn-hover-anim w-full sm:w-auto">
                            <i class="fas fa-envelope mr-2"></i> Odeslat znovu
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-3 text-gray-700 hover:text-gray-900
                                border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-sign-out-alt mr-1"></i> Odhlásit se
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
