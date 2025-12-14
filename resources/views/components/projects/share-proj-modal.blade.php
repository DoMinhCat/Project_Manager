@props(['project', 'not_shared_users'])

<flux:modal.trigger name="share-project-{{ $project->id }}">
    <flux:tooltip content="Share">
        <flux:button size="sm" variant="primary" color="blue" icon="share" />
    </flux:tooltip>
</flux:modal.trigger>

<flux:modal name="share-project-{{ $project->id }}" flyout position="bottom">
    <div class="space-y-6 text-left">
        <div>
            <flux:heading size="lg">Share project</flux:heading>
            <flux:text class="mt-2">Choose users you want to share <strong>{{ $project->name }}</strong> with
            </flux:text>
        </div>

        <form method="POST" action="{{ route('home', $project) }}">
            @csrf

            <div class="space-y-2 max-h-64 overflow-y-auto">
                {{-- @foreach ($not_shared_users as $user) --}}
                <flux:tooltip content="email here">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="users[]" value="user_id" class="rounded border-zinc-300">
                        <span>User name here</span>
                    </label>
                </flux:tooltip>
                {{-- @endforeach --}}
            </div>

            <flux:select label="Permission" name="permission" class="max-w-fit" required>
                <flux:select.option value="view" :selected="$project->priority === 'view'">View only
                </flux:select.option>
                <flux:select.option value="collaborate" :selected="$project->priority === 'collaborate'">Collaborate
                </flux:select.option>
                <flux:select.option value="edit" :selected="$project->priority === 'edit'">Edit
                </flux:select.option>
            </flux:select>
            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Share</flux:button>
            </div>
        </form>

    </div>
</flux:modal>