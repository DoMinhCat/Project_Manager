<x-layout>
    @if(session('success'))
        <div class="w-full max-w-3xl mx-auto mt-4 p-6 mb-3">
            <div x-data="{ visible: true }" x-show="visible" x-collapse>
                <div x-show="visible" x-transition>
                    <flux:callout icon="check" color="green">
                        <flux:callout.heading>{{ session('success') }}</flux:callout.heading>

                        <x-slot name="controls">
                            <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
                        </x-slot>
                    </flux:callout>
                </div>
            </div>
        </div>
    @endif


    <div class="w-full mb-4">
        <h1 class="text-3xl font-bold text-center"> My dashboard </h1>
    </div>


    <div class="w-full responsive grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Tasks by status</h2>
            <ul>
                @foreach($tasksByStatus as $status => $count)
                    <li>{{ $status }} : {{ $count }}</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Overdue tasks</h2>
            <p class="text-red-600 font-bold text-xl">{{ $overdueTasks }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Recent tasks</h2>
            <p class="text-green-600 font-bold text-xl">{{ $recentTasks }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
            <h2 class="font-semibold mb-2">Project overview</h2>           

            @foreach($projects as $project)
                <div class="border p-2 mb-2 rounded">
                    <h3 class="font-bold">{{ $project->name }} ({{ $project->status }})</h3>
                    <p>Total tasks: {{ $project->tasks->count() }}</p>
                    <p>priority: {{ $project->priority}}</p>
                    <p>due date: {{ $project->due_at->format('d/m/Y')}}</p>
                    <p>Completed tasks: {{ $project->tasks->where('done', true)->count() }}</p>
                </div>
            @endforeach
        </div>

        <div x-data="{ open: false }" class="bg-white p-4">
            <button
                @click="open = !open"
                class="w-full flex items-center gap-2 rounded-lg border bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
            >
                Sort by
                <span>▾</span>
            </button>

            <div
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="bg-gray-50 p-4 rounded-lg border shadow-lg"
            >
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'none']) }}" class="block px-4 py-2 font-medium hover:bg-gray-100">
                    None
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'priority']) }}" class="block px-4 py-2 font-medium hover:bg-gray-100">
                    Priority
                </a>

                <a href="{{ request()->fullUrlWithQuery(['sort' => 'due_at']) }}" class="block px-4 py-2 font-medium hover:bg-gray-100">
                    Due date 
                </a>
            </div>
        </div>

    </div>
</x-layout>