<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Projects
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($projects->count() > 0)
                        <div class="space-y-4">
                            @foreach ($projects as $project)
                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                    <div>
                                        <a href="{{ route('projects.show', $project) }}"
                                            class="text-blue-600 hover:underline font-medium">
                                            {{ $project->title }}
                                        </a>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Status: <span class="capitalize">{{ $project->status }}</span>
                                            · Owner: {{ $project->owner->name ?? '—' }}
                                            · Supervisor: {{ $project->supervisor->name ?? 'Not assigned' }}
                                            · Members: {{ $project->members->count() }}
                                        </p>
                                    </div>
                                    <a href="{{ route('projects.show', $project) }}"
                                        class="text-sm text-blue-600 hover:text-blue-800">
                                        View →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No projects yet.</p>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:underline">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
