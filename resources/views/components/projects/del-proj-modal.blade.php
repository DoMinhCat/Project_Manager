@props(['project'])

<flux:modal.trigger name="{{ $project->id }}">
    <flux:button size="sm" variant="danger">
        <flux:icon.trash />
    </flux:button>
</flux:modal.trigger>

<flux:modal :dismissible="false" name="{{ $project->id }}" class="min-w-88">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete {{ $project->name }}?</flux:heading>
            <flux:text class="mt-2">
                You're about to delete this project and all its tasks.<br>
                This action cannot be reversed.
            </flux:text>
        </div>
        <div class="flex gap-2 items-center justify-center">
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <form action="{{ route('project.delete', $project) }}" method="POST">
                @csrf
                @method('DELETE')

                <flux:button variant="danger" type="submit">Confirm</flux:button>
            </form>
        </div>
    </div>
</flux:modal>