@if(config('cookie-consent.enabled') && !request()->cookie(config('cookie-consent.cookie_name')))
<div id="cookieConsentBanner" style="
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9999;
    background: #2d3748;
    color: white;
    padding: 1rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
">
    <div style="flex: 1; padding-right: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0;">🍪 Soubory cookie</h4>
        <p style="margin: 0;">
            Tento web používá soubory cookie k zajištění správného fungování a analýze návštěvnosti.
            <a href="{{ route('page.privacy') }}" style="color: #93c5fd; text-decoration: underline;">Více informací</a>.
        </p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button id="cookieConsentAccept" style="
            padding: 0.5rem 1rem;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        ">
            Přijmout vše
        </button>
    </div>
</div>

<script>
// Гарантированная инициализация после полной загрузки
window.addEventListener('load', function() {
    const banner = document.getElementById('cookieConsentBanner');
    const button = document.getElementById('cookieConsentAccept');
    const cookieName = 'cz_cookie_consent';

    if (!banner || !button) {
        console.error('Cookie consent elements missing');
        return;
    }

    // Проверка существующего согласия
    if (document.cookie.includes(cookieName + '=1')) {
        banner.remove();
        return;
    }

    // Простой обработчик клика
    button.onclick = function() {
        // Установка куки на 1 год
        const date = new Date();
        date.setFullYear(date.getFullYear() + 1);
        document.cookie = `${cookieName}=1; expires=${date.toUTCString()}; path=/; SameSite=Lax`;

        // Анимация и удаление
        banner.style.transition = 'opacity 0.3s ease';
        banner.style.opacity = '0';
        setTimeout(() => banner.remove(), 300);

        console.log('Cookie accepted:', document.cookie);
    };
});
</script>
@endif
