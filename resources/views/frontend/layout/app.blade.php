<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sate Simpang Tiga')</title>

    {{-- load logo loading --}}
    <link rel="preload" as="image" href="{{ asset('images/logo/logo.png') }}" fetchpriority="high">

    {{-- PAGE SPECIFIC PRELOAD --}}
    @stack('preloads')

    {{-- GLOBAL ASSET --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- PAGE / SECTION SPECIFIC STYLE --}}
    @stack('styles')

    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">


</head>

<body class="bg-black text-white font-sans">

    {{-- LOADER --}}
    <div id="loader" class="fixed inset-0 z-[9999]
        bg-black flex items-center justify-center">

        <img src="{{ asset('images/logo/logo.png') }}" alt="Loader" loading="eager" fetchpriority="high"
            decoding="async" data-critical-asset class="loader-image w-28 md:w-36">

    </div>

    @include('sweetalert::alert')

    @include('frontend.sections.navbar')

    <main>
        @yield('content')
    </main>

    @include('frontend.sections.footer')


    {{-- LOADER SCRIPT --}}
    <script>
        (function() {
            const loader = document.getElementById('loader');

            if (!loader) return;

            const MIN_LOADING_TIME = 900;
            const MAX_LOADING_TIME = 7000;

            const startTime = performance.now();

            let isFinished = false;

            function waitForImage(img) {
                return new Promise((resolve) => {
                    function done() {
                        if (img.decode) {
                            img.decode()
                                .then(resolve)
                                .catch(resolve);
                        } else {
                            resolve();
                        }
                    }

                    if (img.complete && img.naturalWidth > 0) {
                        done();
                        return;
                    }

                    img.addEventListener('load', done, {
                        once: true
                    });
                    img.addEventListener('error', resolve, {
                        once: true
                    });
                });
            }

            function hideLoader() {
                if (isFinished) return;

                isFinished = true;

                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';

                setTimeout(() => {
                    loader.style.display = 'none';
                }, 800);
            }

            function finishLoading() {
                const elapsed = performance.now() - startTime;

                const remainingTime = Math.max(
                    0,
                    MIN_LOADING_TIME - elapsed
                );

                setTimeout(hideLoader, remainingTime);
            }

            const hardFallback = setTimeout(() => {
                finishLoading();
            }, MAX_LOADING_TIME);

            document.addEventListener('DOMContentLoaded', () => {
                const criticalImages = Array.from(
                    document.querySelectorAll('[data-critical-asset]')
                );

                const criticalAssetsReady = Promise.allSettled(
                    criticalImages.map(waitForImage)
                );

                criticalAssetsReady.then(() => {
                    clearTimeout(hardFallback);
                    finishLoading();
                });
            });
        })();
    </script>


    {{-- LENIS --}}
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.42/bundled/lenis.min.js"></script>

    <script>
        /**
         * LENIS SMOOTH SCROLL
         * dibuat aman supaya kalau CDN gagal, halaman tetap jalan
         */
        if (typeof Lenis !== 'undefined') {

            const lenis = new Lenis({
                duration: 1.8,
                lerp: 0.06,
                smoothWheel: true,
                wheelMultiplier: 0.9,
            });

            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }

            requestAnimationFrame(raf);

        }


        /**
         * REVEAL ANIMATION
         */
        const revealObserver = new IntersectionObserver((entries) => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }

            });

        }, {
            threshold: 0.15
        });

        document.querySelectorAll(
            '.reveal, .reveal-left, .reveal-right, .reveal-scale'
        ).forEach(el => revealObserver.observe(el));


        /**
         * VIDEO PARALLAX
         */
        let ticking = false;

        window.addEventListener('scroll', () => {

            if (ticking) return;

            ticking = true;

            requestAnimationFrame(() => {

                const scrolled = window.scrollY;

                document.querySelectorAll('.motion-video').forEach(video => {

                    video.style.transform =
                        `scale(1.1) translateY(${scrolled * 0.04}px)`;

                });

                ticking = false;

            });

        });
    </script>


    {{-- PAGE / SECTION SPECIFIC SCRIPT --}}
    @stack('scripts')

</body>

</html>
