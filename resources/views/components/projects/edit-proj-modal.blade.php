@props(['project'])

<flux:modal.trigger name="edit-{{ $project->id }}">
    <flux:button size="sm" variant="primary" color="yellow">
        <flux:icon.pencil-square />
    </flux:button>
</flux:modal.trigger>

<flux:modal name="edit-{{ $project->id }}" flyout variant="floating">
    <div class="space-y-6 text-left">
        <div>
            <flux:heading size="lg">Update {{ $project->name }}
            </flux:heading>
        </div>

        <form action="{{ route('project.update', $project) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')
            <flux:input class="txt-box" label="Name" name="name" value="{{ $project->name }}" />
            <flux:textarea rows="auto" class="txt-box" label="Description" name="description" id="proj-description"
                :value="old('description', $project->description)" />

            <flux:input class=" txt-box" label="Due date" name="due_at" type="date"
                value="{{ old('due_at', optional($project->due_at)->format('Y-m-d')) }}" />

            {{-- <flux:select label="Priority" name="priority" class="max-w-fit">
                <flux:select.option value="low" :selected="$task->priority === 'low'">Low
                </flux:select.option>
                <flux:select.option value="medium" :selected="$task->priority === 'medium'">Medium
                </flux:select.option>
                <flux:select.option value="high" :selected="$task->priority === 'high'">High
                </flux:select.option>
            </flux:select> --}}

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