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

                {{-- Empty --}}
                @if($projects->count() < 1)
                    <div class="container1 text-center">
                        <h2>You haven't created any project yet</h2>
                        <x-projects.create-proj-modal></x-projects.create-proj-modal>
                    </div>
                @else
                    {{-- Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">
                                My Projects
                            </h1>
                            <p class="mt-1 text-sm text-gray-600">
                                Manage and track all your projects in one place
                            </p>
                        </div>
                        @if($projects->count() > 0)
                            <div>
                                <x-projects.create-proj-modal></x-projects.create-proj-modal>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200  overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 ">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Project
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Priority
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Owner
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Deadline
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($projects as $project)
                                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <a href="{{ route('project.detail', $project->id) }}"
                                                    class="flex items-center group">
                                                    <span
                                                        class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                        {{ $project->name }}
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @if($project->status === 'completed') bg-green-100 text-green-700 @elseif($project->status === 'in_progress') bg-blue-100 text-blue-700 @else bg-yellow-100 text-yellow-700 @endif">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full mr-2 @if($project->status === 'completed') bg-green-500 @elseif($project->status === 'in_progress') bg-blue-500 @else bg-yellow-500 @endif"></span>
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                    @if($project->auto_status === 1)
                                                        <flux:tooltip content="Auto status">
                                                            <flux:icon.cog-6-tooth variant="mini" class="size-4 ml-2" />
                                                        </flux:tooltip>
                                                    @else
                                                        <flux:tooltip content="Manual status">
                                                            <flux:icon.wrench variant="mini" class="size-4 ml-2" />
                                                        </flux:tooltip>
                                                    @endif
                                                </span>




                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="font-semibold  @if($project->priority === 'high') text-red-500 @elseif($project->priority === 'medium') text-yellow-500 @else text-green-500 @endif">
                                                    {{ ucfirst($project->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('account', $project->owner->id) }}"
                                                    class="flex items-center group">
                                                    <span
                                                        class="font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">
                                                        {{ $project->owner->name }}
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($project->due_at)
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ $project->due_at->format('d/m/Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-400">No deadline</span>
                                                @endif
                                            </td>

                                            {{-- Action --}}
                                            <td class="px-6 py-4 text-center">
                                                {{-- Edit --}}
                                                <x-projects.edit-proj-modal :project="$project"></x-projects.edit-proj-modal>
                                                {{-- Share --}}
                                                <x-projects.share-proj-modal :project="$project"></x-projects.share-proj-modal>
                                                {{-- Delete --}}
                                                <x-projects.del-proj-modal :project="$project"></x-projects.del-proj-modal>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-medium text-gray-900">{{ $projects->count() }}</span>
                            project{{ $projects->count() !== 1 ? 's' : '' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endauth
</x-layout>