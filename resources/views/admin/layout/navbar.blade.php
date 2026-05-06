<nav
    class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start"
    navbar-main
    navbar-scroll="true"
>

    <div class="flex items-center justify-between w-full px-4 py-2 mx-auto flex-wrap-inherit">

        {{-- LEFT --}}
        <div>

            @php
                $segment = request()->segment(2) ?? 'dashboard';
                $title = ucfirst(str_replace('-', ' ', $segment));
            @endphp

            {{-- BREADCRUMB --}}
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">

                <li class="text-sm leading-normal">
                    <a
                        class="opacity-50 text-slate-500 hover:text-orange-500 transition"
                        href="javascript:;"
                    >
                        Pages
                    </a>
                </li>

                <li
                    class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-400 before:content-['/']"
                    aria-current="page"
                >
                    {{ $title }}
                </li>

            </ol>

            {{-- TITLE --}}
            <h6 class="mb-0 font-bold capitalize text-slate-800 text-xl">
                {{ $title }}
            </h6>

        </div>


        {{-- RIGHT --}}
        <div class="flex items-center gap-4 mt-2 sm:mt-0">

            {{-- CART --}}
            <a
                href="{{ route('cart.index') }}"
                class="relative flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-md hover:border-orange-500 hover:bg-orange-50 transition-all duration-300 hover:scale-105"
            >

                {{-- ICON --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-slate-700"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h12m-9 0a1 1 0 102 0m6 0a1 1 0 102 0"
                    />
                </svg>

                {{-- BADGE --}}
                @php
                    $cartCount = count(session('cart', []));
                @endphp

                @if($cartCount > 0)

                    <span
                        id="cartBadge"
                        class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 flex items-center justify-center rounded-full bg-orange-500 text-white text-[10px] font-bold shadow-lg shadow-orange-500/40 animate-pulse"
                    >
                        {{ $cartCount }}
                    </span>

                @endif

            </a>


            {{-- HIDE SIDEBAR BUTTON --}}
            <button
                id="toggle-sidebar"
                class="group flex items-center justify-center h-11 w-11 rounded-2xl bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg hover:shadow-orange-500/40 hover:scale-105 active:scale-95 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                title="Toggle Sidebar"
            >

                <i class="fas fa-bars text-lg transition-transform duration-300 group-hover:rotate-90"></i>

            </button>

        </div>

    </div>

</nav>
