<x-layout>
    @guest
        <x-unauth>

        </x-unauth>
    @endguest

    @auth
        Single Proj page
    @endauth
</x-layout>