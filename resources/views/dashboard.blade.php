<x-layout>
    @guest
        <x-unauth></x-unauth>
    @endguest
    @if (session('success'))
        @foreach (session('success') as $message)
            <div class="w-full max-w-3xl mx-auto mt-4 p-6 mb-3">
                <div x-data="{ visible: true }" x-show="visible" x-collapse>
                    <div x-show="visible" x-transition>
                        <flux:callout icon="check" color="green">
                            <flux:callout.heading>{{ $message }}</flux:callout.heading>
                            <x-slot name="controls">
                                <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
                            </x-slot>
                        </flux:callout>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="w-full mb-4">
        <h1 class="text-3xl font-bold text-center">My dashboard</h1>
    </div>

    <div class="w-full responsive grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Tasks by status</h2>
            <ul>
                @foreach ($tasksByStatus as $status => $count)
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

            @foreach ($projects as $project)
                <div class="border p-2 mb-2 rounded">
                    <h3 class=" font-bold">{{ $project->name }} ({{ $project->status }})</h3>
                    <p>Total tasks: {{ $project->tasks->count() }}</p>
                    <p class="flex items-center gap-1">
                        <span>Priority:</span>
                        <span
                            class="@if ($project->priority === 'high') text-red-600 font-bold @elseif($project->priority === 'medium') text-orange-500 font-bold @else text-green-600 font-bold @endif">
                            {{ ucfirst($project->priority) }}
                        </span>
                    </p>
                    <p><span>Deadline:</span>
                        @if ($project->due_at)
                            <span class="text-blue-400">{{ $project->due_at->format('d/m/Y') }}</span>
                        @else
                            <span class="text-gray-400">No deadline</span>
                        @endif
                    </p>
                    <p>Completed tasks: {{ $project->tasks->where('status', true)->count() }}</p>
                </div>
            @endforeach
        </div>

        <div x-data="{ open: false }" class="bg-white p-4">
            <button @click="open = !open"
                class="w-full flex items-center gap-2 rounded-lg border bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Sort projects by
                <span>▾</span>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition
                class=" bg-gray-50 p-4 rounded-lg border shadow-lg">
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'none']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $sort === 'none' || !$sort ? 'font-bold text-blue-600' : 'font-medium' }}">
                    None
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $sort === 'name' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Name
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'priority']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $sort === 'priority' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Priority
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'due_at']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $sort === 'due_at' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Due date
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'number_of_tasks']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $sort === 'number_of_tasks' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Number of tasks
                </a>
            </div>
        </div>
    </div>

    <!-- Section des tâches avec filtres -->
    <div class="w-full responsive grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
            <h2 class="font-semibold mb-2">Tasks overview</h2>

            @foreach ($tasks as $task)
                <div class="border p-2 mb-2 rounded">
                    <h3 class="font-bold">{{ $task->name }}</h3>
                    <p class="text-sm text-gray-600">Project:
                        @if ($task->project)
                            {{ $task->project->name }}
                        @else
                            <span class="text-gray-400">No project</span>
                        @endif
                    </p>
                    <p class="flex items-center gap-1">
                        <span>Status:</span>
                        <span
                            class="@if ($task->status) text-green-600 font-bold @else text-orange-500 font-bold @endif">
                            {{ $task->status ? 'Completed' : 'In progress' }}
                        </span>
                    </p>
                    <p class="flex items-center gap-1">
                        <span>Priority:</span>
                        <span
                            class="@if ($task->priority === 'high') text-red-600 font-bold @elseif($task->priority === 'medium') text-orange-500 font-bold @else text-green-600 font-bold @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </p>
                    <p><span>Due date:</span>
                        @if ($task->due_at)
                            <span
                                class="@if ($task->due_at < now() && !$task->status) text-red-600 font-bold @else text-blue-400 @endif">
                                {{ $task->due_at->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-gray-400">No due date</span>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>

        <div x-data="{ open: false }" class="bg-white p-4">
            <button @click="open = !open"
                class="w-full flex items-center gap-2 rounded-lg border bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Sort tasks by
                <span>▾</span>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition
                class="bg-gray-50 p-4 rounded-lg border shadow-lg">
                <a href="{{ request()->fullUrlWithQuery(['task_sort' => 'none']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $taskSort === 'none' || !$taskSort ? 'font-bold text-blue-600' : 'font-medium' }}">
                    None
                </a>
                <a href="{{ request()->fullUrlWithQuery(['task_sort' => 'name']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $taskSort === 'name' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Name
                </a>
                <a href="{{ request()->fullUrlWithQuery(['task_sort' => 'status']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $taskSort === 'status' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Status
                </a>
                <a href="{{ request()->fullUrlWithQuery(['task_sort' => 'priority']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $taskSort === 'priority' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Priority
                </a>
                <a href="{{ request()->fullUrlWithQuery(['task_sort' => 'due_at']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $taskSort === 'due_at' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Due date
                </a>
                <a href="{{ request()->fullUrlWithQuery(['task_sort' => 'project']) }}"
                    class="block px-4 py-2 font-medium hover:bg-gray-100 {{ $taskSort === 'project' ? 'font-bold text-blue-600' : 'font-medium' }}">
                    Project
                </a>
            </div>
        </div>
    </div>

    <div class="w-full mb-6 mt-8">
        <h2 class="text-2xl font-semibold mb-4">Statistiques</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white p-4 rounded shadow lg:col-span-3">
                <h3 class="font-semibold mb-3 text-center">Répartition des tâches par projet</h3>
                <canvas id="tasksByProjectChart" height="80"></canvas>
            </div>

            <div class="bg-white p-4 rounded shadow lg:col-span-3 flex flex-col items-center">
                <h3 class="font-semibold mb-3 text-center">Taux de complétion</h3>
                <div style="width: 300px; height: 300px;">
                    <canvas id="completionChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        const completionCtx = document.getElementById('completionChart').getContext('2d');
        const completedTasks = {{ $tasksCompletionRate['completed'] ?? 0 }};
        const pendingTasks = {{ $tasksCompletionRate['pending'] ?? 0 }};

        new Chart(completionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Complétées', 'En attente'],
                datasets: [{
                    data: [completedTasks, pendingTasks],
                    backgroundColor: ['#00d800ff', '#ffec1dff'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = completedTasks + pendingTasks;
                                const percentage = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        const tasksByProjectCtx = document.getElementById('tasksByProjectChart').getContext('2d');
        new Chart(tasksByProjectCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($tasksByProject->keys()) !!},
                datasets: [{
                    label: 'Nombre de tâches',
                    data: {!! json_encode($tasksByProject->values()) !!},
                    backgroundColor: '#8b5cf6',
                    borderColor: '#7c3aed',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</x-layout>
