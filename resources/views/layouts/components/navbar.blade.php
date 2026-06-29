<nav id="navbar" class="fixed top-0 z-50 w-full bg-[#444422]">
    <div class="mx-auto max-w-[1440px] px-8 lg:px-[48px]">
        <div class="flex h-[108px] items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg border border-white/30 bg-white/20 shadow-lg">
                    <img
                        src="{{ asset('icons/logo-book.svg') }}"
                        alt="STUDEE Logo"
                        class="h-9 w-9"
                    >
                </div>

                <a href="{{ route('dashboard') }}" class="text-2xl font-black text-white">
                    STUDEE
                </a>
            </div>

            <div class="hidden items-center gap-[38px] md:flex">
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('tasks.index') }}" class="nav-link">My Task</a>
            </div>

            <div class="hidden items-center gap-6 md:flex">
                @auth
                    <span class="text-white font-bold">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn-glass">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn-glass">Register</a>
                @endauth
            </div>

            <button id="menu-btn" class="md:hidden text-3xl font-bold text-white" aria-label="Open menu">
                =
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden space-y-2 bg-[#444422] px-4 pb-4 md:hidden">
        <a href="{{ route('dashboard') }}" class="mobile-link">Dashboard</a>
        <a href="{{ route('tasks.index') }}" class="mobile-link">My Task</a>
    </div>
</nav>

<script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
