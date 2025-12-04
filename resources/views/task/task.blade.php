<x-layout>
    @guest
        <x-unauth></x-unauth>
    @endguest

    @auth
        <div class="container1 w-full max-w-3xl mx-auto p-6">
            <h1 class="title mb-6 text-center">Task Information</h1>

            <div class="space-y-3">
                <p><strong>Title:</strong> {{ $task->title }}</p>
                <p><strong>Description:</strong> {{ $task->description ?? '-' }}</p>

                <p>
                    <strong>Priority:</strong> 
                    <span class="
                        @if($task->priority === 1) text-green-500
                        @elseif($task->priority === 2) text-yellow-500
                        @else($task->priority === 3) text-red-500 @endif">
                        
                        @switch($task->priority)
                            @case(1) Low @break
                            @case(2) Medium @break
                            @case(3) High @break
                            @default N/A
                        @endswitch
                    </span>
                </p>

                <p>
                    <strong>Status:</strong> 
                    <span class="
                        {{ $task->done === 0 ? 'text-red-500' : 'text-green-500' }}">
                        {{ $task->done === 0 ? 'Incompleted' : 'Completed' }}
                    </span>
                </p>

                <p><strong>Created on:</strong> {{ $task->created_at->format('d/m/Y') }}</p>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('project.detail', $project->id) }}" class="btn-blue inline-block">
                    Back to {{ $project->name }}
                </a>
            </div>
        </div>
    @endauth
</x-layout>
