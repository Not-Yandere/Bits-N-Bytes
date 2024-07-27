<div id="cookieConsent">
    This website uses cookies to ensure you get the best experience on our website. <a href="/privacy-policy">Learn more</a>
    <button id="acceptCookiesButton">Accept</button>
</div>

<script>
    function acceptCookies() {
        document.cookie = "cookieConsent=true; max-age=" + 60 * 60 * 24 * 365 + "; path=/";
        localStorage.setItem('cookieConsent', 'true');
        document.getElementById('cookieConsent').style.display = 'none';
    }

    function checkCookieConsent() {
        const cookies = document.cookie.split(';').map(cookie => cookie.trim());
        const cookieConsentCookie = cookies.find(cookie => cookie.startsWith('cookieConsent='));
        const cookieConsentLocalStorage = localStorage.getItem('cookieConsent');

        if (!cookieConsentCookie && !cookieConsentLocalStorage) {
            setTimeout(() => {
                document.getElementById('cookieConsent').style.display = 'block';
            }, 500); // Delay the display by 500ms
        }
    }

    window.onload = function() {
        checkCookieConsent();
        document.getElementById('acceptCookiesButton').addEventListener('click', acceptCookies);
    };
</script>
