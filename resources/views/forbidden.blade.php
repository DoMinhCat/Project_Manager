<x-layout>
    <div class="container1 bg-red-100 text-red-800 text-center">
        <h2 class="text-lg font-semibold mb-4">403 Forbidden</h2>
        <p>You don't have the correct permisison to perform this action.</p>
        <a href="{{ route('dashboard') }}" class="btn-blue w-full sm:w-auto mx-auto inline-block">
            Go to Dashboard
        </a>
    </div>
</x-layout>