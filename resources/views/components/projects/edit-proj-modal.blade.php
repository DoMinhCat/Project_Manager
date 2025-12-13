@props(['project'])

<flux:modal.trigger name="edit-proj-{{ $project->id }}">
    <flux:tooltip content="Edit">
        <flux:button size="sm" variant="primary" icon="pencil-square" color="yellow" />
    </flux:tooltip>
</flux:modal.trigger>

<flux:modal name="edit-proj-{{ $project->id }}" flyout variant="floating">
    <div class="space-y-6 text-left">
        <div>
            <flux:heading size="lg">Update {{ $project->name }}
            </flux:heading>
        </div>

        <form action="{{ route('project.update', $project) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')
            <flux:input class="txt-box" label="Name" name="name" required value="{{ $project->name }}" />
            <flux:textarea rows="auto" class="txt-box" label="Description" name="description" id="proj-description"
                :value="old('description', $project->description)" />

            <flux:input class=" txt-box" label="Due date" name="due_at" type="date"
                value="{{ old('due_at', optional($project->due_at)->format('Y-m-d')) }}" />

            <div class="flex flex-row justify-between">
                <flux:select label="Priority" name="priority" class="max-w-fit" required>
                    <flux:select.option value="low" :selected="$project->priority === 'low'">Low
                    </flux:select.option>
                    <flux:select.option value="medium" :selected="$project->priority === 'medium'">Medium
                    </flux:select.option>
                    <flux:select.option value="high" :selected="$project->priority === 'high'">High
                    </flux:select.option>
                </flux:select>
                <flux:select label="Status" name="status" class="max-w-fit" required>
                    <flux:select.option value="on_hold" :selected="$project->status === 'on_hold'">On hold
                    </flux:select.option>
                    <flux:select.option value="in_progress" :selected="$project->status === 'in_progress'">In progress
                    </flux:select.option>
                    <flux:select.option value="completed" :selected="$project->status === 'completed'">Completed
                    </flux:select.option>
                </flux:select>
            </div>
            <input type="hidden" name="auto_status" value="0">

            <div class="flex flex-row gap-2">
                <flux:checkbox label="Enable auto status" value="1" name="auto_status"
                    :checked="$project->auto_status===1" />
                <flux:tooltip content="Project status will be automatically set based on tasks status">
                    <flux:icon.information-circle icon:variant="mini" />
                </flux:tooltip>
            </div>

            <button type="submit" class="btn-blue">
                Save changes
            </button>
        </form>
    </div>
</flux:modal>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const textarea = document.getElementById('proj-description');
        if (textarea && !textarea.value.trim()) {
            textarea.value = @json(old('description', $project->description));
        }
    });
</script>