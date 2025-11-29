<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Task Manager' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @fluxAppearance --}}
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-blue-800 shadow">
        <nav class="container mx-auto p-5">
            <div class="flex items-center justify-between">
                <div class="flex justify-center-safe">
                    <div class="flex items-center space-x-6">
                        @guest
                            <x-nav-link :href="route('home')" :active="Route::is('home')">
                                Home
                            </x-nav-link>
                        @endguest
                        @auth
                            <x-nav-link :href="route('dashboard')" :active="Route::is('dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link :href="route('projects')" :active="Route::is('projects')">
                                Projects
                            </x-nav-link>
                        @endauth
                        <x-nav-link :href="route('about')" :active="Route::is('about')">
                            About us
                        </x-nav-link>
                    </div>
                </div>
                <div class="flex justify-center-safe">
                    <div class="flex items-center space-x-6">
                        @guest
                            <x-nav-link :href="route('login')" :active="Route::is('login') || Route::is('register')">
                                Sign in
                            </x-nav-link>
                        @endguest
                        @auth
                            <flux:dropdown position="bottom" align="end" style="btn-blue">
                                <flux:button icon:trailing="chevron-down">{{ Auth::user()->name }}</flux:button>

                                <flux:menu>
                                    <flux:menu.item href="{{ route('account', ['user_id' => Auth::user()->id]) }}"
                                        icon="user">
                                        Account
                                    </flux:menu.item>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <flux:menu.item type="submit" icon="arrow-right-start-on-rectangle"
                                            variant="danger">
                                            Logout
                                        </flux:menu.item>
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8 flex flex-col items-center">
        {{ $slot }}
    </main>

    <footer class="bg-blue-800 text-white mt-auto">
        <div class="container mx-auto px-4 py-6 text-center">
            <p>&copy; {{ date('Y') }} - Task Manager</p>
        </div>
    </footer>
    @fluxScripts
</body>

</html>