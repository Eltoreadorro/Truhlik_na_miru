@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl mt-10">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Vrácení zboží a reklamace</h1>
        <div class="w-24 h-1 bg-red-600 mx-auto"></div>
    </div>

    <!-- Podmínky vrácení -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-10">
        <div class="bg-gradient-to-r from-red-600 to-red-800 p-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Podmínky vrácení
            </h2>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <!-- Zákonná lhůta -->
                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Zákonná lhůta</h3>
                    </div>
                    <p class="text-gray-700">Podle § 1829 občanského zákoníku máte právo vrátit zboží do <strong class="text-red-600">14 dnů</strong> od převzetí bez udání důvodu.</p>
                </div>

                <!-- Stav zboží -->
                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Stav zboží</h3>
                    </div>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>Zboží musí být <strong>nepoužité</strong></li>
                        <li>V původním obalu a s etiketami</li>
                        <li>Bez známek poškození</li>
                    </ul>
                </div>

                <!-- Postup vrácení -->
                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Postup vrácení</h3>
                    </div>
                    <ol class="list-decimal pl-5 space-y-2 text-gray-700">
                        <li>Vyplňte <a href="{{ route('download.return.form') }}" class="text-blue-600 underline hover:text-blue-800">formulář pro vrácení</a></li>
                        <li>Zasílejte na adresu: <strong>Sulicka 42, Sulice, 25168 Praha-vychod</strong></li>
                        <li>Náklady na dopravu hradí zákazník</li>
                    </ol>
                </div>
            </div>

            <!-- Výjimky -->
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-5 rounded-r-lg">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-bold text-yellow-800 mb-2">Výjimky z práva na vrácení</h3>
                        <p class="text-yellow-700">Zboží vyrobené na míru (podle vašich specifikací) nelze vrátit podle § 1837 občanského zákoníku.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Náhrada peněz -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-800 p-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Náhrada peněz
            </h2>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Před expedicí -->
                <div class="border border-green-200 bg-green-50 rounded-lg p-5 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold text-green-800 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Před expedicí
                    </h3>
                    <ul class="list-disc pl-5 space-y-2 text-green-700">
                        <li>Při zrušení objednávky <strong>před odesláním</strong></li>
                        <li>Vrátíme <strong>100%</strong> částky</li>
                        <li>Do <strong>5 pracovních dnů</strong></li>
                    </ul>
                </div>

                <!-- Po převzetí -->
                <div class="border border-blue-200 bg-blue-50 rounded-lg p-5 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold text-blue-800 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Po převzetí
                    </h3>
                    <ul class="list-disc pl-5 space-y-2 text-blue-700">
                        <li>Účtujeme manipulační poplatek <strong>89 Kč</strong></li>
                        <li>Výjimka: reklamace a vadné zboží</li>
                        <li>Vrácení do <strong>14 dnů</strong> od obdržení</li>
                    </ul>
                </div>
            </div>

            <!-- Kontakt -->
            <div class="mt-8 bg-gray-50 p-5 rounded-lg border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kontakt pro reklamace
                </h3>
                <p class="text-gray-700">Máte-li jakékoli dotazy, kontaktujte nás na <a href="mailto:truhliknamiru@gmail.com" class="text-blue-600 underline hover:text-blue-800">truhliknamiru@gmail.com</a> nebo na telefonním čísle <strong>+420 606 912 403</strong>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
