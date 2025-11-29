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
                        <h2>Task Manager</h2>
                        <x-nav-link :href="route('home')" :active="Route::is('home')">
                            Home
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="Route::is('dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('projects')" :active="Route::is('projects')">
                            Projects
                        </x-nav-link>
                        <x-nav-link :href="route('about')" :active="Route::is('about')">
                            About us
                        </x-nav-link>
                    </div>
                </div>
                <div>
                    <div class="flex items-center space-x-6">
                        <x-nav-link :href="route('login')" :active="Route::is('login')">
                            Sign in
                        </x-nav-link>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8 flex flex-col">
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