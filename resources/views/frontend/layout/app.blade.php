<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sate Simpang Tiga')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <link rel="preload" as="image" href="{{ asset('images/hero/backgroundsate.png') }}">

    <link rel="preload" as="video" href="{{ asset('videos/sate.mp4') }}" type="video/mp4">
</head>

<body class="bg-black text-white font-sans">

    {{-- LOADER --}}
    <div id="loader" class="fixed inset-0 z-[9999]
    bg-black flex items-center justify-center">

        <img src="{{ asset('images/logo/logo.png') }}" alt="Loader" class="loader-image w-28 md:w-36">

    </div>

    @include('sweetalert::alert')

    @include('frontend.sections.navbar')

    <main>
        @yield('content')
    </main>

    @include('frontend.sections.footer')

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, {
            threshold: 0.2
        });
        document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale')
            .forEach(el => observer.observe(el));
    </script>

    {{-- LENIS --}}
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.42/bundled/lenis.min.js"></script>

    <script>
        // LENIS SMOOTH SCROLL
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

        // REVEAL ANIMATION
        const observer = new IntersectionObserver((entries) => {

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
        ).forEach(el => observer.observe(el));

        // VIDEO PARALLAX
        window.addEventListener('scroll', () => {

            const scrolled = window.scrollY;

            document.querySelectorAll('.motion-video').forEach(video => {

                video.style.transform =
                    `scale(1.1) translateY(${scrolled * 0.04}px)`;

            });

        });
    </script>

    <script>
        window.addEventListener('load', () => {

            const loader =
                document.getElementById('loader');

            setTimeout(() => {

                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';

            }, 1200);

        });
    </script>

</body>

</html>
