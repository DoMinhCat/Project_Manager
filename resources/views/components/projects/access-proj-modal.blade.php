@props(['project', 'users'])

<flux:modal.trigger name="manage-access">
    <flux:tooltip content="Manage access">
        <flux:button size="sm" variant="primary" color="blue" icon="user-circle" />
    </flux:tooltip>
</flux:modal.trigger>

<flux:modal name="manage-access" flyout position="bottom">
    <form method="POST" action="{{ route('project.updateAccess', $project) }}">
        @csrf
        @method('PATCH')

        <div class="space-y-6 text-left">
            <div>
                <flux:heading size="lg">Manage access</flux:heading>
                <flux:subheading class="mt-1">
                    Control who can access <strong>{{ $project->name }}</strong>
                </flux:subheading>
            </div>

            <div>
                <flux:label class="mb-3">Users with access</flux:label>
                <div
                    class="space-y-2 max-h-96 overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg p-3">
                    @forelse ($users as $user)
                        <div class="flex items-center gap-3 p-3 rounded bg-zinc-50 dark:bg-zinc-800">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-sm">{{ $user->name }}</div>
                                <div class="text-xs text-zinc-500 truncate">{{ $user->email }}</div>
                            </div>

                            <div class="flex items-center gap-3">
                                <flux:select name="permissions[{{ $user->id }}]" required>
                                    <flux:select.option value="view" :selected="$project->userPermission($user) === 'view'">
                                        View only
                                    </flux:select.option>
                                    <flux:select.option value="collaborate"
                                        :selected="$project->userPermission($user) === 'collaborate'">Collaborate
                                    </flux:select.option>
                                    <flux:select.option value="edit" :selected="$project->userPermission($user) === 'edit'">
                                        Edit
                                    </flux:select.option>
                                </flux:select>
                                <flux:tooltip content="Provoke access">
                                    <flux:switch name="access[{{ $user->id }}]" value="1" checked />
                                </flux:tooltip>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-zinc-500 text-sm">
                            <div class="mb-2">No users have access yet</div>
                            <flux:text>Share this project to grant access</flux:text>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </div>
    </form>
</flux:modal>