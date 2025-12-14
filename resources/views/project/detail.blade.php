<x-layout>
    @guest
        <x-unauth></x-unauth>
    @endguest

    @auth
        <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                {{-- Success --}}
                <x-response.success></x-response.success>
                {{-- Error --}}
                <x-response.error :errors="$errors"></x-response.error>

                {{-- Nav breadcrumbs --}}
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('project.all') }}">Projects</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="#">{{ $project->name }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-5 mb-8 gap-4">
                    <div class="space-y-3">

                        {{-- Title + Author --}}
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                                {{ $project->name }}
                            </h1>

                            <p class="mt-1 text-sm text-gray-500">
                                Created by
                                <span class="font-medium text-gray-700">{{ $project->owner->name }}</span>
                            </p>
                        </div>

                        {{-- Deadline --}}
                        @if ($project->due_at)
                            <div class="flex items-center text-sm text-red-600">
                                <flux:icon.calendar class="w-5 h-5 mr-2" />
                                <span class="font-medium">
                                    {{ $project->due_at->format('d/m/Y') }}
                                </span>
                            </div>
                        @else
                            <span class="text-sm text-gray-400">No deadline</span>
                        @endif

                        @if ($project->description)
                            <p class="text-sm leading-relaxed text-gray-700 mt-2">
                                {{ $project->description }}
                            </p>
                        @endif

                    </div>


                    @if($tasks->count() > 0 && ($project->userPermission(Auth::user()) == 'owner' || $project->userPermission(Auth::user()) == 'edit'))
                        <div>
                            <x-tasks.create-task-modal :project="$project"></x-tasks.create-task-modal>
                        </div>
                    @endif
                </div>

                {{-- Empty State --}}
                @if($tasks->count() < 1)
                    <div class="container1 text-center">
                        <h2>No tasks yet for this project</h2>
                        <x-tasks.create-task-modal :project="$project"></x-tasks.create-task-modal>
                    </div>
                @else

                    {{-- Tasks Table --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-20">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Task</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Priority</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Deadline</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($tasks as $task)
                                        <tr class="hover:bg-blue-50 transition-colors duration-150">

                                            {{-- Task --}}
                                            <td class="px-6 py-4">
                                                <flux:modal.trigger name="edit-task-{{ $task->id }}">
                                                    <a href="#" class="flex items-center group">
                                                        <span
                                                            class="@if($task->status === 1) line-through text-gray-500 @else text-gray-900 font-semibold @endif group-hover:text-blue-600 transition-colors">
                                                            {{ $task->name }}
                                                        </span>
                                                    </a>
                                                </flux:modal.trigger>
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-6 py-4 text-center">
                                                @if($project->userPermission(Auth::user()) != 'view')
                                                    <form action="{{ route('task.updateStatus', [$project, $task]) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status"
                                                            value="@if($task->status === 1) 0 @else 1 @endif">

                                                        <flux:tooltip content="Mark as done">
                                                            <button type="submit"><span
                                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @if($task->status === 1) bg-green-100 text-green-700 hover:bg-gray-100 hover:text-gray-700 @else bg-gray-100 text-gray-700 hover:bg-green-100 hover:text-green-700  @endif">
                                                                    <flux:icon.check-circle />
                                                                </span>
                                                            </button>
                                                        </flux:tooltip>
                                                    </form>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @if($task->status === 1) bg-green-100 text-green-700 @else bg-gray-100 text-gray-700 @endif">
                                                        <flux:icon.check-circle />
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Priority --}}
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="font-semibold  @if($task->priority === 'high') text-red-500 @elseif($task->priority === 'medium') text-yellow-500 @else text-green-500 @endif">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>

                                            {{-- Deadline --}}
                                            <td class="px-6 py-4 text-center text-gray-600">
                                                @if ($task->due_at)
                                                    <div class="flex items-center text-sm text-gray-700">
                                                        <flux:icon.calendar class="w-4 h-4 mr-1.5 text-gray-400" />
                                                        {{ $task->due_at->format('d/m/Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-400">No deadline</span>
                                                @endif
                                            </td>

                                            {{-- Action --}}
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center gap-1">
                                                    @if($project->userPermission(Auth::user()) == 'owner' || $project->userPermission(Auth::user()) == 'edit')
                                                        {{-- Edit --}}
                                                        <x-tasks.edit-task-modal :task="$task"></x-tasks.edit-task-modal>
                                                        {{-- Delete --}}
                                                        <x-tasks.del-task-modal :task="$task"></x-tasks.del-task-modal>
                                                    @else
                                                        <span class="text-sm text-gray-400">No action available</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-medium text-gray-900">{{ $tasks->count() }}</span>
                            task{{ $tasks->count() !== 1 ? 's' : '' }}
                        </p>
                    </div>

                @endif
            </div>

            @if($project->userPermission(Auth::user()) == 'owner' || $project->userPermission(Auth::user()) == 'edit')
                <div class="m-6">
                    <flux:separator />
                </div>

                {{-- Project edit zone --}}
                <div class="max-w-7xl mx-auto text-center gap-3">
                    <x-projects.edit-proj-modal :project="$project"></x-projects.edit-proj-modal>
                    <x-projects.share-proj-modal :project="$project" :users="$project->notSharedUsers()"></x-projects.share-proj-modal>
                    <x-projects.access-proj-modal :project="$project" :users="$project->sharedUsers()"></x-projects.access-proj-modal>
                    {{-- Delete --}}
                    @if($project->userPermission(Auth::user()) == 'owner')
                        <x-projects.del-proj-modal :project="$project"></x-projects.del-proj-modal>
                    @endif
                </div>
            @endif
        </div>
    @endauth
</x-layout>