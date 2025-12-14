@props(['task'])

<flux:modal.trigger name="delete-{{ $task->id }}">
    <flux:tooltip content="Delete {{ $task->name }}">
        <flux:button size="sm" variant="danger" icon="trash" />
    </flux:tooltip>
</flux:modal.trigger>

<flux:modal :dismissible="false" name="delete-{{ $task->id }}" class="min-w-88">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete {{ $task->name }}?</flux:heading>
            <flux:text class="mt-2">
                You're about to delete this task.<br>
                This action cannot be reversed.
            </flux:text>
        </div>

        <div class="flex gap-2 items-center justify-center">
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <form action="{{ route('task.delete', [$task->project, $task]) }}" method="POST">
                @csrf
                @method('DELETE')
                <flux:button variant="danger" type="submit">Confirm
                </flux:button>
            </form>
        </div>
    </div>
</flux:modal>