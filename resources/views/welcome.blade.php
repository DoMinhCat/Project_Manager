<x-layout>

    {{-- ERROR/SUCCESS MSG --}}
    @if(session('success'))
        <div class="w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl">
            <div x-data="{ visible: true }" x-show="visible" x-collapse>
                <div x-show="visible" x-transition>
                    <flux:callout icon="check" color="green">
                        <flux:callout.heading>{{ session('success') }}</flux:callout.heading>

                        <x-slot name="controls">
                            <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
                        </x-slot>
                    </flux:callout>
                </div>
            </div>
        </div>
    @endif

    <!-- HERO SECTION -->
    <section class="container1 text-center responsive">
        <h1 class="title1 text-4xl font-bold mb-4">
            Welcome to Task Manager
        </h1>

        <p class="text-gray-700 text-lg leading-relaxed mb-6">
            Organize your tasks, track your projects and stay productive with our simple and intuitive application.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-4">
            <a href="{{ route('register') }}" class="btn-blue">
                Create a new account
            </a>
            <a href="{{ route('login') }}" class="btn-blue">
                Sign in
            </a>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="container1 responsive">
        <h2 class="text-gray-900 text-3xl font-semibold mb-6 text-center">
            Principle features
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="card">
                <h3>Tasks and projects management</h3>
                <p>Create, edit and organize your tasks with ease.</p>
            </div>

            <div class="card">
                <h3>Project follow-up</h3>
                <p>Visualize the progress of your projects and prioritize your tasks effectively with our built-in
                    dashboard.</p>
            </div>

            <div class="card">
                <h3>Notification and reminder</h3>
                <p>Never miss a deadline again thanks to our in-app reminders.</p>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="container1 responsive text-center">
        <h2 class="text-3xl font-semibold mb-4">
            Why choose us?
        </h2>

        <p class="text-gray-700 text-lg leading-relaxed mb-6">
            Our app is designed to maximize your productivity and simplify your daily task management.
            <br>
            Whether you're a student, professional, or team, Task Manager helps you stay organized.
        </p>

        <a href="{{ route('register') }}" class="btn-blue">
            Get started now
        </a>
    </section>

</x-layout>