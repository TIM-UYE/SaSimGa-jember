(function () {
    const SOURCE_LANG = 'id';
    const LANG_STORAGE_KEY = 'selectedLanguage';

    function getRootDomain() {
        const hostname = window.location.hostname;

        if (hostname === 'localhost' || hostname === '127.0.0.1' || hostname.split('.').length <= 1) {
            return null;
        }

        return '.' + hostname
            .split('.')
            .slice(-2)
            .join('.');
    }

    function setCookie(name, value) {
        document.cookie = `${name}=${value}; path=/`;

        const rootDomain = getRootDomain();

        if (rootDomain) {
            document.cookie = `${name}=${value}; path=/; domain=${rootDomain}`;
        }
    }

    function deleteCookie(name) {
        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;

        const rootDomain = getRootDomain();

        if (rootDomain) {
            document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=${rootDomain}`;
        }
    }

    function changeLanguage(lang) {
        if (!lang) 
            return;
        
        localStorage.setItem(LANG_STORAGE_KEY, lang);

        if (lang === SOURCE_LANG) {
            deleteCookie('googtrans');
        } else {
            setCookie('googtrans', `/${SOURCE_LANG}/${lang}`);
        }

        window
            .location
            .reload();
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

    function initLanguageDropdown() {
        const savedLanguage = localStorage.getItem(LANG_STORAGE_KEY) || SOURCE_LANG;

        updateLanguageUI(savedLanguage);

        document
            .querySelectorAll('[data-language-dropdown]')
            .forEach(function (dropdown) {
                const toggle = dropdown.querySelector('[data-language-toggle]');
                const items = dropdown.querySelectorAll('[data-lang]');

                if (!toggle) 
                    return;
                
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
    };

    function loadGoogleTranslateScript() {
        if (document.getElementById('google-translate-script')) 
            return;
        
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
})();