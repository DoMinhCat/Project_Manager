<x-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow space-y-6">

        <h1 class="text-2xl font-semibold text-center text-blue-800">
            Sign in to your Task Manager account
        </h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf

            <flux:input label="Email" type="email" name="email" placeholder="Enter your email"
                value="{{ old('email') }}" />

            <flux:input label="Password" type="password" name="password" placeholder="Enter your password" />

            <button type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded-lg font-medium transition">
                Sign in
            </button>
        </form>

        <p class="text-center text-sm text-gray-600">
            Don't have an account ?
            <a href="{{ route('register') }}" class="text-blue-700 hover:underline">
                Create a new account
            </a>
        </p>

    </div>
</x-layout>