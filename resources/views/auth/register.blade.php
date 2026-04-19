@extends('layouts.app')

@section('title', 'Register')

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
                Create Account
            </h1>
            <p class="text-[#3B3B1A]/70 text-sm mt-1">
                Start managing your tasks & focus time
            </p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/30
                        text-red-700 text-sm
                        p-3 rounded-xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- NAME --}}
            <div>
                <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                    Name
                </label>
                <input
                    type="text"
                    name="name"
                    required
                    placeholder="Your name"
                    class="w-full rounded-xl
                           bg-[#3B3B1A]/10
                           border border-white/40
                           px-4 py-3
                           text-[#3B3B1A]
                           placeholder:text-[#3B3B1A]/50
                           focus:outline-none
                           focus:ring-2 focus:ring-[#8A784E]/50">
            </div>

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

            {{-- CONFIRM PASSWORD --}}
            <div>
                <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                    Confirm Password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
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
                Register
            </button>
        </form>

        {{-- LOGIN --}}
        <div class="text-center text-sm text-[#3B3B1A]/70">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-[#8A784E] font-semibold hover:underline">
                Login
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
