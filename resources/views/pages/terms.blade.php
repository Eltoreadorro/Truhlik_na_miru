@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl mt-10">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Obchodní podmínky</h1>
        <div class="w-24 h-1 bg-purple-600 mx-auto"></div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 p-6">
            <h2 class="text-2xl font-bold text-white">Všeobecné obchodní podmínky</h2>
        </div>
        <div class="p-6">
            <!-- 1. Obecná ustanovení -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-8 h-8 flex items-center justify-center">1</span>
                    Obecná ustanovení
                </h3>
                <div class="pl-10">
                    <p class="text-gray-700 mb-4">Provozovatelem e-shopu je <strong>[Yurii Kolesnyk]</strong>, IČO: <strong>[17578981]</strong>, se sídlem <strong>Sulicka 42, Sulice, 25168 Praha-vychod</strong>, zapsaná v obchodním rejstříku vedeném Městským soudem v Praze, oddíl C, vložka 123456.</p>
                    <p class="text-gray-700">Tyto obchodní podmínky upravují vztah mezi prodávajícím a kupujícím v souladu s ustanoveními § 2079 a násl. zákona č. 89/2012 Sb., občanského zákoníku.</p>
                </div>
            </div>

            <!-- 2. Ceny a platby -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-8 h-8 flex items-center justify-center">2</span>
                    Ceny a platby
                </h3>
                <div class="pl-10">
                    <ul class="list-disc pl-5 space-y-3 text-gray-700">
                        <li>Všechny ceny jsou uvedeny v <strong>Kč včetně DPH</strong> a dalších zákonných poplatků.</li>
                        <li>Akceptujeme následující platební metody:
                            <ul class="list-disc pl-5 mt-2 space-y-2">
                                <li>Platba kartou online prostřednictvím platební brány</li>
                                <li>Bankovní převod na účet č. <strong>4753073093/0800</strong></li>
                            </ul>
                        </li>
                        <li>Zboží je rezervováno na <strong>24 hodin</strong> do dokončení platby. Po uplynutí této doby může být objednávka automaticky stornována.</li>
                    </ul>
                </div>
            </div>

            <!-- 3. Dodací podmínky -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-8 h-8 flex items-center justify-center">3</span>
                    Dodací podmínky
                </h3>
                <div class="pl-10">
                    <ul class="list-disc pl-5 space-y-3 text-gray-700">
                        <li>Zboží expedujeme do <strong>24 hodin</strong> po přijetí platby (v pracovní dny).</li>
                        <li>Výroba na zakázku trvá <strong>3-5 pracovních dnů</strong>.</li>
                        <li>Možnosti dopravy:
                            <ul class="list-disc pl-5 mt-2 space-y-2">
                                <li>Česká pošta - 89 Kč (2-3 pracovní dny)</li>
                                <li>PPL - 129 Kč (1-2 pracovní dny)</li>
                                <li>Osobní odběr - zdarma (dle domluvy)</li>
                            </ul>
                        </li>
                        <li>Podrobné informace naleznete v sekci <a href="{{ route('page.delivery') }}" class="text-purple-600 underline hover:text-purple-800">Doprava a platby</a>.</li>
                    </ul>
                </div>
            </div>

            <!-- 4. Reklamace -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-8 h-8 flex items-center justify-center">4</span>
                    Reklamace a vrácení zboží
                </h3>
                <div class="pl-10">
                    <ul class="list-disc pl-5 space-y-3 text-gray-700">
                        <li>Reklamace řešíme do <strong>14 dnů</strong> od doručení zboží.</li>
                        <li>Zboží lze vrátit do <strong>14 dnů</strong> bez udání důvodu.</li>
                        <li>Podrobné podmínky naleznete v sekci <a href="{{ route('page.returns') }}" class="text-purple-600 underline hover:text-purple-800">Vrácení zboží</a>.</li>
                        <li>Kontakt pro reklamace: <strong>truhliknamiru@gmail.com</strong> nebo <strong>420 606 912 403</strong>.</li>
                    </ul>
                </div>
            </div>

            <!-- 5. Závěrečná ustanovení -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-8 h-8 flex items-center justify-center">5</span>
                    Závěrečná ustanovení
                </h3>
                <div class="pl-10">
                    <ul class="list-disc pl-5 space-y-3 text-gray-700">
                        <li>Veškeré spory budou řešeny příslušným soudem v České republice.</li>
                        <li>Tyto obchodní podmínky nabývají účinnosti dnem <strong>1. 1. 2023</strong>.</li>
                        <li>Provozovatel si vyhrazuje právo změnit tyto podmínky. Aktuální verze je vždy zveřejněna na těchto stránkách.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
