<x-layout>
    @guest
        <x-unauth></x-unauth>
    @endguest

    @auth
        <div class="container1 w-full max-w-3xl mx-auto mt-4 p-6">
            {{-- Nav breadcrumbs --}}
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('project.all') }}">Projects</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('project.detail', $project) }}">{{ $project->name }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="#">{{ $task->name }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="title mb-6 text-center">Task Information</h1>

            <div class="space-y-3">
                <p><strong>Title:</strong> {{ $task->name }}</p>
                <p><strong>Description:</strong> {{ $task->description ?? '-' }}</p>
                <p>
                    <strong>Priority:</strong> 
                    <span class="
                        @if($task->priority === "low") text-green-500
                        @elseif($task->priority === "medium") text-yellow-500
                        @else text-red-500 @endif">
                        
                        @switch($task->priority)
                            @case("low") Low @break
                            @case("medium") Medium @break
                            @case("high") High @break
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
