<x-layout>
    @guest
        <x-unauth></x-unauth>
    @endguest

    @auth
        <div class="container1 w-full max-w-3xl mx-auto mt-4 p-6">
            {{-- Nav breadcrumbs --}}
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('project.all') }}">Projects</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('project.detail', $project) }}">{{ $project->name }}
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">Edit {{ $task->name }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="title1">Edit a task</h1>

            <form action="{{ route('task.update', [$project, $task]) }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')
                <flux:input class="txt-box" label="Name" name="name" value="{{ $task->name }}" />
                <flux:textarea class="txt-box" label="Description" name="description" value="{{ $task->description }}" />

                <flux:input class="txt-box" label="Due date" name="due_at" type="date"
                    placeholder="Choose the due date of the task" value="{{ old('due_at') }}" />

                <flux:select label="Priority" name="priority" class="max-w-fit">
                    <flux:select.option value="low" :selected="$task->priority === 'low'">Low</flux:select.option>
                    <flux:select.option value="medium" :selected="$task->priority === 'medium'">Medium</flux:select.option>
                    <flux:select.option value="high" :selected="$task->priority === 'high'">High</flux:select.option>
                </flux:select>

                <button type="submit" class="btn-blue inline-block">
                    Save changes
                </button>
            </form>
        </div>

    @endauth
</x-layout>