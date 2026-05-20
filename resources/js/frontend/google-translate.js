(function () {
    const SOURCE_LANG = 'id';
    const LANG_STORAGE_KEY = 'selectedLanguage';
    const GOOGLE_COOKIE_NAME = 'googtrans';
    const RELOAD_FLAG_KEY = 'googleTranslateReloadedOnce';

    function isLocalhost(hostname) {
        return (
            hostname === 'localhost' || hostname === '127.0.0.1' || /^\d+\.\d+\.\d+\.\d+$/.test(hostname)
        );
    }

    function getCookieDomains() {
        const hostname = window.location.hostname;
        const domains = [null];

        if (!isLocalhost(hostname)) {
            domains.push(hostname);

            const parts = hostname.split('.');

            if (parts.length >= 2) {
                domains.push('.' + parts.slice(-2).join('.'));
            }
        }

        return [...new Set(domains)];
    }

    function setCookie(name, value, domain = null) {
        let cookie = `${name}=${value}; path=/; SameSite=Lax`;

        if (domain) {
            cookie += `; domain=${domain}`;
        }

        document.cookie = cookie;
    }

    function deleteCookie(name, domain = null) {
        let cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;

        if (domain) {
            cookie += ` domain=${domain};`;
        }

        document.cookie = cookie;
    }

    function clearGoogleTranslateCookies() {
        getCookieDomains().forEach(function (domain) {
            deleteCookie(GOOGLE_COOKIE_NAME, domain);
        });
    }

    function clearGoogleTranslateState() {
        localStorage.removeItem(LANG_STORAGE_KEY);
        sessionStorage.removeItem(RELOAD_FLAG_KEY);
        clearGoogleTranslateCookies();
    }

    function setGoogleTranslateCookie(lang) {
        const value = `/${SOURCE_LANG}/${lang}`;

        getCookieDomains().forEach(function (domain) {
            setCookie(GOOGLE_COOKIE_NAME, value, domain);
        });
    }

    function getGoogleCombo() {
        return document.querySelector('.goog-te-combo');
    }

    function triggerGoogleTranslate(lang) {
        const combo = getGoogleCombo();

        if (!combo) {
            return false;
        }

        combo.value = lang;
        combo.dispatchEvent(new Event('change', {bubbles: true}));

        return true;
    }

    function updateLanguageUI(lang) {
        const currentLabels = document.querySelectorAll('[data-language-current]');
        const activeItems = document.querySelectorAll('[data-lang]');

        activeItems.forEach(function (item) {
            const isActive = item.dataset.lang === lang;

            item
                .classList
                .toggle('is-active', isActive);

            if (isActive) {
                currentLabels.forEach(function (label) {
                    label.textContent = item.dataset.label || lang.toUpperCase();
                });
            }
        });
    }

    function closeAllDropdowns() {
        document
            .querySelectorAll('[data-language-dropdown]')
            .forEach(function (dropdown) {
                dropdown
                    .classList
                    .remove('is-open');
            });
    }

    function applyLanguage(lang, reloadOnFail = false) {
        if (!lang || lang === SOURCE_LANG) {
            return;
        }

        setGoogleTranslateCookie(lang);

        let attempt = 0;

        const interval = setInterval(function () {
            const success = triggerGoogleTranslate(lang);

            if (success) {
                clearInterval(interval);
                sessionStorage.removeItem(RELOAD_FLAG_KEY);
                return;
            }

            attempt++;

            if (attempt >= 30) {
                clearInterval(interval);

                if (reloadOnFail && sessionStorage.getItem(RELOAD_FLAG_KEY) !== lang) {
                    sessionStorage.setItem(RELOAD_FLAG_KEY, lang);
                    location.reload();
                }
            }
        }, 250);
    }

    function changeLanguage(lang) {
        if (!lang) {
            return;
        }

        closeAllDropdowns();

        if (lang === SOURCE_LANG) {
            resetLanguage();
            return;
        }

        clearGoogleTranslateCookies();

        localStorage.setItem(LANG_STORAGE_KEY, lang);
        sessionStorage.removeItem(RELOAD_FLAG_KEY);

        updateLanguageUI(lang);
        setGoogleTranslateCookie(lang);
        applyLanguage(lang, true);
    }

    function resetLanguage() {
        clearGoogleTranslateState();
        updateLanguageUI(SOURCE_LANG);
        location.reload();
    }

    function initLanguageDropdown() {
        const savedLanguage = localStorage.getItem(LANG_STORAGE_KEY) || SOURCE_LANG;

        updateLanguageUI(savedLanguage);

        document
            .querySelectorAll('[data-language-dropdown]')
            .forEach(function (dropdown) {
                const toggle = dropdown.querySelector('[data-language-toggle]');
                const items = dropdown.querySelectorAll('[data-lang]');

                if (!toggle) {
                    return;
                }

                toggle.addEventListener('click', function (event) {
                    event.stopPropagation();

                    const isOpen = dropdown
                        .classList
                        .contains('is-open');

                    closeAllDropdowns();

                    if (!isOpen) {
                        dropdown
                            .classList
                            .add('is-open');
                    }
                });

                items.forEach(function (item) {
                    item.addEventListener('click', function () {
                        changeLanguage(this.dataset.lang);
                    });
                });
            });

        document.addEventListener('click', closeAllDropdowns);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeAllDropdowns();
            }
        });
    }

    window.googleTranslateElementInit = function () {
        new google
            .translate
            .TranslateElement({
                pageLanguage: SOURCE_LANG,
                includedLanguages: 'id,en,ja,ko,ar',
                autoDisplay: false
            }, 'google_translate_element');

        const savedLanguage = localStorage.getItem(LANG_STORAGE_KEY);

        if (savedLanguage && savedLanguage !== SOURCE_LANG) {
            setTimeout(function () {
                applyLanguage(savedLanguage, false);
            }, 500);
        }
    };

    function loadGoogleTranslateScript() {
        if (document.getElementById('google-translate-script')) {
            return;
        }

        const script = document.createElement('script');

        script.id = 'google-translate-script';
        script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementI' +
                'nit';
        script.async = true;

        document
            .body
            .appendChild(script);
    }

    document.addEventListener('DOMContentLoaded', function () {
        initLanguageDropdown();
        loadGoogleTranslateScript();
    });

    window.changeLanguage = changeLanguage;
    window.resetLanguage = resetLanguage;
})();