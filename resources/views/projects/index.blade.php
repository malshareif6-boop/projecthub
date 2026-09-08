<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">My Project</h2>
                <p class="text-sm text-gray-500 mt-1">Your graduation project overview</p>
            </div>
            @if ($projects->isEmpty())
                <a href="{{ route('projects.create') }}"
                    class="inline-flex items-center gap-1.5 self-start bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    New Project
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('success'))
                <div
                    class="bg-emerald-50 text-emerald-800 text-sm font-medium px-4 py-3 rounded-xl ring-1 ring-emerald-600/20">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($projects as $project)
                @php
                    $progress = app(\App\Services\ProgressCalculator::class)->calculate($project);
                    $health = app(\App\Services\ProjectHealthCalculator::class)->calculate($project);
                    $healthClasses = match ($health) {
                        'Good' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                        'Needs Attention' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                        default => 'bg-red-50 text-red-700 ring-red-600/20',
                    };
                @endphp

                <div
                    class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden hover:ring-indigo-200 transition">
                    <div class="p-5 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <a href="{{ route('projects.show', $project) }}"
                                        class="text-lg font-semibold text-gray-900 hover:text-indigo-600 transition truncate">
                                        {{ $project->title }}
                                    </a>
                                    <span
                                        class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold ring-1 ring-inset {{ $healthClasses }}">
                                        {{ $health }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">
                                    <span class="capitalize">{{ $project->status }}</span>
                                    · Supervisor: {{ $project->supervisor->name ?? 'Not assigned' }}
                                    · Members: {{ $project->members->count() }}/5
                                </p>

                                <div class="mt-3 flex items-center gap-3 max-w-xs">
                                    <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-indigo-500 h-1.5 rounded-full"
                                            style="width: {{ max($progress, 2) }}%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-indigo-600">{{ $progress }}%</span>
                                </div>
                            </div>

                            <a href="{{ route('projects.show', $project) }}"
                                class="inline-flex items-center gap-1.5 self-start text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition shrink-0">
                                View
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-12 text-center">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No project yet</h3>
                    <p class="text-gray-500 text-sm mb-6">Create your graduation project to get started.</p>
                    <a href="{{ route('projects.create') }}"
                        class="inline-flex bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
                        Create Project
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
