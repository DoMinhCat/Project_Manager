<x-layout>
   @if(session('success'))
        <div class="w-full responsive">
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
                    <p>Completed tasks: {{ $project->tasks->where('done', true)->count() }}</p>
                </div>
            @endforeach
        </div>

    </div>
</x-layout>