@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl pt-20">
    <!-- Základní informace -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 animate__animated animate__fadeIn">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">
                <i class="fas fa-user-edit mr-2"></i> Úprava profilu
            </h3>
        </div>
        <div class="p-6">
            @if(session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Jméno</label>
                    <input type="text"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300 @error('name') border-red-500 @enderror text-gray-800 bg-white"
                           id="name" name="name"
                           value="{{ old('name', $user->name) }}"
                           required>
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300 @error('email') border-red-500 @enderror text-gray-800 bg-white"
                           id="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           required>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="block text-gray-700 font-medium mb-2">Telefon</label>
                    <input type="tel"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300 @error('phone') border-red-500 @enderror text-gray-800 bg-white"
                           id="phone" name="phone"
                           value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary mt-4">
                    <i class="fas fa-save mr-2"></i> Uložit změny
                </button>
            </form>
        </div>
    </div>

    <!-- Změna hesla -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 animate__animated animate__fadeIn animate__delay-1s">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">
                <i class="fas fa-key mr-2"></i> Změna hesla
            </h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password" class="block text-gray-700 font-medium mb-2">Aktuální heslo</label>
                    <input type="password"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300 @error('current_password') border-red-500 @enderror text-gray-800 bg-white"
                           id="current_password" name="current_password" required>
                    @error('current_password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Nové heslo</label>
                    <input type="password"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300 @error('password') border-red-500 @enderror text-gray-800 bg-white"
                           id="password" name="password" required>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Potvrzení hesla</label>
                    <input type="password"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300 text-gray-800 bg-white"
                           id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-warning mt-4">
                    <i class="fas fa-key mr-2"></i> Aktualizovat heslo
                </button>
            </form>
        </div>
    </div>

    <!-- Smazání účtu -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden animate__animated animate__fadeIn animate__delay-2s">
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">
                <i class="fas fa-exclamation-triangle mr-2"></i> Smazání účtu
            </h3>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">Po smazání účtu budou všechna vaše data trvale odstraněna. Před pokračováním si prosím uložte veškeré důležité informace.</p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('DELETE')

                <div class="form-group">
                    <label for="delete_password" class="block text-gray-700 font-medium mb-2">Heslo pro potvrzení</label>
                    <input type="password"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-transparent transition duration-300 @error('delete_password') border-red-500 @enderror text-gray-800 bg-white"
                           id="delete_password" name="password" required>
                    @error('delete_password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-danger mt-4" onclick="return confirm('Jste si jisti? Tuto akci nelze vrátit zpět!')">
                    <i class="fas fa-trash-alt mr-2"></i> Smazat účet
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dynamická validace hesla
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('password_confirmation');

        function validatePassword() {
            if (passwordField.value !== confirmField.value) {
                confirmField.setCustomValidity("Hesla se neshodují");
                confirmField.classList.add('border-red-500');
            } else {
                confirmField.setCustomValidity("");
                confirmField.classList.remove('border-red-500');
            }
        }

        passwordField.addEventListener('change', validatePassword);
        confirmField.addEventListener('keyup', validatePassword);

        // Animace při načítání
        const cards = document.querySelectorAll('.animate__animated');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
        });
    });
</script>
@endsection
