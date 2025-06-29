@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl mt-10">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Ochrana osobních údajů</h1>
        <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Tato politika ochrany osobních údajů popisuje, jak nakládáme s vašimi osobními údaji v souladu s Nařízením EU 2016/679 (GDPR).</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Záhlaví -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6">
            <h2 class="text-2xl font-bold text-white">Zásady ochrany osobních údajů</h2>
        </div>

        <!-- Obsah -->
        <div class="p-6">
            <!-- 1. Správce údajů -->
            <div class="mb-10">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Správce údajů
                </h3>
                <div class="pl-9">
                    <p class="text-gray-700 mb-3">Správcem osobních údajů je:</p>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="font-semibold">[Yurii Kolesnyk]</p>
                        <p>IČO: 17578981</p>
                        <p>Adresa: Sulicka 42, Sulice, 25168 Praha-vychod</p>
                        <p>Email: truhliknamiru@gmail.com</p>
                        <p>Telefon: +420 606 912 403</p>
                    </div>
                    <p class="text-gray-700 mt-3">Pověřenec pro ochranu údajů: Yurii Kolesnyk, email: truhliknamiru@gmail.com</p>
                </div>
            </div>

            <!-- 2. Zpracovávané údaje -->
            <div class="mb-10">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Zpracovávané údaje
                </h3>
                <div class="pl-9">
                    <p class="text-gray-700 mb-3">Zpracováváme následující kategorie osobních údajů:</p>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Identifikační údaje</h4>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                <li>Jméno a příjmení</li>
                                <li>Doručovací adresa</li>
                                <li>Email a telefon</li>
                            </ul>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Platební údaje</h4>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                <li>Číslo účtu (při převodu)</li>
                                <li>Fakturační údaje</li>
                                <li>Platební transakce (zpracovává externí poskytovatel)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Účel zpracování -->
            <div class="mb-10">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Účel zpracování
                </h3>
                <div class="pl-9">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Účel</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Právní základ</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doba uchování</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-2 text-gray-700">Plnění smlouvy (dodání zboží)</td>
                                    <td class="px-4 py-2 text-gray-700">Čl. 6(1)(b) GDPR</td>
                                    <td class="px-4 py-2 text-gray-700">5 let od dodání</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-4 py-2 text-gray-700">Daňové povinnosti</td>
                                    <td class="px-4 py-2 text-gray-700">Čl. 6(1)(c) GDPR</td>
                                    <td class="px-4 py-2 text-gray-700">10 let</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-gray-700">Marketing (s souhlasem)</td>
                                    <td class="px-4 py-2 text-gray-700">Čl. 6(1)(a) GDPR</td>
                                    <td class="px-4 py-2 text-gray-700">3 roky nebo do odvolání souhlasu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 4. Vaše práva -->
            <div class="mb-10">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Vaše práva podle GDPR
                </h3>
                <div class="pl-9">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="border border-blue-100 bg-blue-50 rounded-lg p-5">
                            <div class="flex items-center gap-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <h4 class="text-lg font-bold text-blue-800">Právo na přístup</h4>
                            </div>
                            <p class="text-blue-700">Můžete žádat informace o tom, jaké vaše údaje zpracováváme.</p>
                        </div>

                        <div class="border border-green-100 bg-green-50 rounded-lg p-5">
                            <div class="flex items-center gap-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <h4 class="text-lg font-bold text-green-800">Právo na opravu</h4>
                            </div>
                            <p class="text-green-700">Můžete požadovat opravu nepřesných osobních údajů.</p>
                        </div>

                        <div class="border border-red-100 bg-red-50 rounded-lg p-5">
                            <div class="flex items-center gap-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <h4 class="text-lg font-bold text-red-800">Právo na výmaz</h4>
                            </div>
                            <p class="text-red-700">Můžete požádat o smazání údajů, pokud již nejsou potřebné.</p>
                        </div>

                        <div class="border border-purple-100 bg-purple-50 rounded-lg p-5">
                            <div class="flex items-center gap-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <h4 class="text-lg font-bold text-purple-800">Právo na přenositelnost</h4>
                            </div>
                            <p class="text-purple-700">Můžete získat údaje ve strojově čitelném formátu.</p>
                        </div>
                    </div>

                    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-500 p-5 rounded-r-lg">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h4 class="text-lg font-bold text-yellow-800 mb-2">Stížnost u dozorového úřadu</h4>
                                <p class="text-yellow-700">Máte právo podat stížnost u <a href="https://www.uoou.cz/" class="text-yellow-800 underline hover:text-yellow-900" target="_blank">Úřadu pro ochranu osobních údajů</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Kontakt -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kontakt
                </h3>
                <div class="pl-9">
                    <p class="text-gray-700 mb-4">Pro uplatnění vašich práv nebo s dotazy ohledně ochrany osobních údajů nás kontaktujte:</p>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 max-w-md">
                        <p class="font-semibold">Email: <a href="mailto:gdpr@example.com" class="text-blue-600 hover:underline">truhliknamiru@gmail.com</a></p>
                        <p class="font-semibold">Telefon: +420 606 912 403</p>
                        <p class="font-semibold">Adresa: Sulicka 42, Sulice, 25168 Praha-vychod</p>
                    </div>
                    <p class="text-gray-700 mt-4">Tato politika nabývá účinnosti dne 1. 1. 2023.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
