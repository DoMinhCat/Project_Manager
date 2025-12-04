@props(['project'])

<flux:modal.trigger name="new-task-modal">
    <button
        class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Task
    </button>
</flux:modal.trigger>

<flux:modal name="new-task-modal" flyout variant="floating">
    <div class="space-y-6 text-left">
        <div>
            <flux:heading size="lg">Create a Task
            </flux:heading>
        </div>

        <form action="{{ route('task.create', $project) }}" method="POST" class="space-y-5">
            @csrf

            <flux:input class="txt-box" label="Name" name="name" placeholder="Give your task a name"
                value="{{ old('name') }}" />

            <flux:textarea class="txt-box" label="Description" name="description" placeholder="Easy peasy task"
                value="{{ old('description') }}" />

            <flux:input class="txt-box" label="Due date" name="due_at" type="date"
                placeholder="Choose the due date of the task" value="{{ old('due_at') }}" />

            <flux:select label="Priority" name="priority" class="max-w-fit" placeholder="Choose a priority">
                <flux:select.option value="low">Low</flux:select.option>
                <flux:select.option value="medium">Medium</flux:select.option>
                <flux:select.option value="high">High</flux:select.option>
            </flux:select>

            <button type="submit" class="btn-blue mt-3">
                Create
            </button>
        </form>
    </div>
</flux:modal>