<x-layout>
    @guest
        <x-unauth>

        </x-unauth>
    @endguest

    @auth
        <div class="container1">

            <h1 class="title1">
                Create a new project
            </h1>

            <form action="{{ route('project.submit') }}" method="POST" class="space-y-5">
                @csrf

                <flux:input class="txt-box" label="Name" name="name" placeholder="Give your project a name"
                    value="{{ old('name') }}" />

                <flux:textarea class="txt-box" label="Description" name="description"
                    placeholder="This is a wonderful project" value="{{ old('description') }}" />

                <flux:input class="txt-box" label="Due date" name="due_at" type="date"
                    placeholder="Choose the due date of the project" value="{{ old('deadline') }}" />

                <button type="submit" class="btn-blue">
                    Create
                </button>
            </form>

        </div>
    @endauth
</x-layout>