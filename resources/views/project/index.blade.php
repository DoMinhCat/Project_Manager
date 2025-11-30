@guest
    <div class="w-full responsive">
        <flux:callout icon="x-mark" color="red">
            <flux:callout.heading>You need to sign in to view this page.</flux:callout.heading>
            <x-slot name="actions">
                <flux:button class="btn-blue" href="/login">Sign in</flux:button>
            </x-slot>
        </flux:callout>
    </div>
@endguest

@auth
    @if($projects->count() < 1)
        <x-layout>
            <div class="container1 text-center">
                <h2>You haven't created any project yet</h2>
                <a href="{{ route('new_project') }}" class="btn-blue">
                    Create my first project
                </a>
            </div>
        </x-layout>
    @else
        <x-layout>
            @foreach ($projects as $project)
                <a href="{{ route('one_project', $project->id) }}">
                    <div
                        class="card dark:bg-neutral-900 border dark:border-neutral-800 hover:shadow-lg transition cursor-pointer p-4 rounded-xl">
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col">
                                <p> Project's name: {{ $project->title }} </p>
                                <p> Owner: {{ $project->owner->name ?? 'N/A' }} </p>
                            </div>
                            <div>
                                <span class="px-2 py-1 rounded-lg text-xs font-medium 
                                                    @if($project->status === 'completed') bg-green-500/20 text-green-400 
                                                    @elseif($project->status === 'in-progress') bg-blue-500/20 text-blue-400
                                                    @else bg-neutral-500/20 text-neutral-400 
                                                    @endif
                                                ">
                                    {{ ucfirst($project->status) }}
                                </span>

                            </div>
                        </div>

                        @if ($project->due_at)
                            <div class="mt-4 text-sm text-neutral-500">
                                Deadline: {{ $project->due_at->format('d/m/Y')}}
                            </div>
                        @endif

                        <div class="mt-2 text-sm">
                            <strong>{{ $project->tasks->count() . $project->tasks->count() > 1 ? 'tasks' : 'task' }} </strong>
                        </div>
                    </div>

                </a>
            @endforeach
        </x-layout>
    @endif
@endauth