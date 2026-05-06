<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
  <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
    <nav>
      @php
        // determine a simple title based on second url segment or route name
        $segment = request()->segment(2) ?? 'dashboard';
        $title = ucfirst(str_replace('-', ' ', $segment));
      @endphp
      <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
        <li class="text-sm leading-normal">
          <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
        </li>
        <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">
          {{ $title }}
        </li>
      </ol>
      <h6 class="mb-0 font-bold capitalize">{{ $title }}</h6>
    </nav>

    <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto justify-end">
      <!-- HIDE SIDEBAR BUTTON -->
      <button id="toggle-sidebar" class="p-3 mr-4 rounded-xl bg-linear-to-r from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50" title="Hide Sidebar">
        <i class="fas fa-bars text-lg"></i>
      </button>
    </div>
  </div>
</nav>
