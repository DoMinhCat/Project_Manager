@props(['project', 'users'])

<flux:modal.trigger name="share-project-{{ $project->id }}">
    <flux:tooltip content="Share">
        <flux:button size="sm" variant="primary" color="blue" icon="share" />
    </flux:tooltip>
</flux:modal.trigger>

<flux:modal name="share-project-{{ $project->id }}" flyout position="bottom">
    <form method="POST" action="{{ route('project.share', $project) }}">
        @csrf

        <div class="space-y-6 text-left">
            <div>
                <flux:heading size="lg">Share project</flux:heading>
                <flux:subheading class="mt-1">
                    Choose users you want to share <strong>{{ $project->name }}</strong> with
                </flux:subheading>
            </div>

            <div>
                <flux:label class="mb-3">Select users</flux:label>
                <div
                    class="space-y-2 max-h-64 overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg p-3">
                    @forelse ($users as $user)
                        <label
                            class="flex items-center gap-3 p-2 rounded hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer transition-colors">
                            <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                class="rounded border-zinc-300 text-blue-600 focus:ring-2 focus:ring-blue-500">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-sm">{{ $user->name }}</div>
                                <div class="text-xs text-zinc-500 truncate">{{ $user->email }}</div>
                            </div>
                        </label>
                    @empty
                        <div class="text-center py-4 text-zinc-500 text-sm">
                            No users available to share with
                        </div>
                    @endforelse
                </div>
            </div>

            <div>
                <flux:select label="Permission" name="permission" required>
                    <flux:select.option value="view">View only</flux:select.option>
                    <flux:select.option value="collaborate">Collaborate</flux:select.option>
                    <flux:select.option value="edit">Edit</flux:select.option>
                </flux:select>
            </div>

            <div class="flex gap-3 pt-2">
                <flux:spacer />
                <flux:button type="button" variant="ghost" flux:close>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Share project</flux:button>
            </div>
        </div>
    </form>
</flux:modal>