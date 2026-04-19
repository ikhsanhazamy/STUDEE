@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen bg-[#E7EFC7] flex items-center justify-center px-4">

    <div class="w-full max-w-md
                backdrop-blur-xl bg-white/15
                border border-white/30
                rounded-3xl shadow-2xl
                p-8 animate-slide-up space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-[#3B3B1A]">
                Welcome Back
            </h1>
            <p class="text-[#3B3B1A]/70 text-sm mt-1">
                Login to continue your focus journey
            </p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/30
                        text-red-700 text-sm
                        p-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    placeholder="you@example.com"
                    class="w-full rounded-xl
                           bg-[#3B3B1A]/10
                           border border-white/40
                           px-4 py-3
                           text-[#3B3B1A]
                           placeholder:text-[#3B3B1A]/50
                           focus:outline-none
                           focus:ring-2 focus:ring-[#8A784E]/50">
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="w-full rounded-xl
                           bg-[#3B3B1A]/10
                           border border-white/40
                           px-4 py-3
                           text-[#3B3B1A]
                           placeholder:text-[#3B3B1A]/50
                           focus:outline-none
                           focus:ring-2 focus:ring-[#8A784E]/50">
            </div>

            {{-- REMEMBER + FORGOT --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-[#3B3B1A]/70">
                    <input type="checkbox"
                           name="remember"
                           class="rounded border-white/40 bg-white/40">
                    Remember me
                </label>

                <a href="#"
                   class="text-[#8A784E] hover:underline font-medium">
                    Forgot password?
                </a>
            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="w-full mt-2
                       bg-[#8A784E]
                       text-[#E7EFC7]
                       py-3 rounded-xl
                       font-semibold
                       hover:bg-[#7A6A45]
                       hover:scale-[1.02]
                       transition-all duration-300
                       shadow-lg">
                Login
            </button>
        </form>

        {{-- REGISTER --}}
        <div class="text-center text-sm text-[#3B3B1A]/70">
            Don’t have an account?
            <a href="{{ route('register') }}"
               class="text-[#8A784E] font-semibold hover:underline">
                Register
            </a>
        </div>

    </div>
</div>

{{-- ANIMATION --}}
<style>
@keyframes slide-up {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slide-up {
    animation: slide-up .6s ease-out;
}
</style>
@endsection
