@props(['task'])

<flux:modal.trigger name="edit-{{ $task->id }}">
    <flux:button size="sm" variant="primary" color="yellow">
        <flux:icon.pencil-square />
    </flux:button>
</flux:modal.trigger>

<flux:modal name="edit-{{ $task->id }}" flyout variant="floating">
    <div class="space-y-6 text-left">
        <div>
            <flux:heading size="lg">Update {{ $task->name }}</flux:heading>
        </div>

        <form action="{{ route('task.update', [$task->project, $task]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')
            <flux:input class="txt-box" label="Name" name="name" value="{{ $task->name }}" />
            <flux:textarea class="txt-box" label="Description" name="description" value="{{ $task->description }}" />

            <flux:input class="txt-box" label="Due date" name="due_at" type="date"
                placeholder="Choose the due date of the task" value="{{ old('due_at') }}" />

            <flux:select label="Priority" name="priority" class="max-w-fit">
                <flux:select.option value="low" :selected="$task->priority === 'low'">Low
                </flux:select.option>
                <flux:select.option value="medium" :selected="$task->priority === 'medium'">Medium
                </flux:select.option>
                <flux:select.option value="high" :selected="$task->priority === 'high'">High
                </flux:select.option>
            </flux:select>

            <button type="submit" class="btn-blue">
                Save changes
            </button>
        </form>
    </div>
</flux:modal>