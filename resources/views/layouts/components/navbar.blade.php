<nav id="navbar"
class="fixed top-0 w-full z-50
bg-white/5 backdrop-blur-sm
transition-all duration-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <!-- LOGO -->
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center border border-white/30 shadow-lg">
                    <img 
                        src="{{ asset('icons/logo-book.svg') }}" 
                        alt="STUDEE Logo"
                        class="w-9 h-9"
                    >
                </div>

                <a href="{{ route('dashboard') }}" class="text-2xl font-black text-white">
                    STUDEE
                </a>
            </div>


            <!-- MENU DESKTOP -->
            <div class="hidden md:flex gap-2">
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('tasks.index') }}" class="nav-link">My Tasks</a>
            </div>

            <!-- AUTH -->
            <div class="hidden md:flex items-center gap-3">
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

            <!-- MOBILE BUTTON -->
            <button id="menu-btn" class="md:hidden text-white">
                ☰
            </button>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-2 bg-white/10 backdrop-blur-xl">
        <a href="{{ route('dashboard') }}" class="mobile-link">Dashboard</a>
        <a href="{{ route('tasks.index') }}" class="mobile-link">My Tasks</a>
    </div>
</nav>

<!-- SCROLL SCRIPT -->
<script>
    const navbar = document.getElementById('navbar');
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            navbar.classList.add(
                'bg-white/10',
                'backdrop-blur-xl',
                'border-b',
                'border-white/20',
                'shadow-2xl'
            );
        } else {
            navbar.classList.remove(
                'bg-white/10',
                'backdrop-blur-xl',
                'border-b',
                'border-white/20',
                'shadow-2xl'
            );
        }
    });

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
