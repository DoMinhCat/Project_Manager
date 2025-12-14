<x-layout>
    @auth
        <div class="w-full max-w-md mx-auto mt-20">
            <div class="container1 bg-green-100 text-green-800 text-center">
                <h2 class="text-lg font-semibold mb-4">You are signed in as {{ Auth::user()->name }}.</h2>

                <a href="/dashboard" class="btn-blue w-full sm:w-auto mx-auto inline-block">
                    Go to dashboard
                </a>
            </div>
        </div>
    @endauth
    @guest
        <div class="container1">

            <h1 class="title1">
                Sign in to Project Manager
            </h1>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <flux:input class="txt-box" label="Email" type="email" name="email" placeholder="Enter your email" required
                    value="{{ old('email') }}" />

                <flux:input class="txt-box" label="Password" type="password" name="password" required
                    placeholder="Enter your password" />

                <button type="submit" class="btn-blue inline-block">
                    Sign in
                </button>
            </form>

            <p class="text-center text-sm text-gray-600">
                Don't have an account yet ?
                <a href="{{ route('register') }}" class="text-blue-700 hover:underline">
                    Create a new account
                </a>
            </p>

        </div>
    @endguest
</x-layout>