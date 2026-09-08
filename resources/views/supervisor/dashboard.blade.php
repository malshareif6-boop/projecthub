<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Supervisor Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Projects assigned to you</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($projects->count() > 0)
                <div class="space-y-4">
                    @foreach ($projects as $project)
                        @php
                            $health = app(\App\Services\ProjectHealthCalculator::class)->calculate($project);
                            $progress = app(\App\Services\ProgressCalculator::class)->calculate($project);
                            $healthClasses = match ($health) {
                                'Good' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                'Needs Attention' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                default => 'bg-red-50 text-red-700 ring-red-600/20',
                            };
                        @endphp

                        <div
                            class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-5 hover:ring-indigo-200 transition">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-3 mb-1">
                                        <a href="{{ route('projects.show', $project) }}"
                                            class="text-lg font-semibold text-gray-900 hover:text-indigo-600 transition truncate">
                                            {{ $project->title }}
                                        </a>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold ring-1 ring-inset {{ $healthClasses }} shrink-0">
                                            {{ $health }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <span class="capitalize">{{ $project->status }}</span>
                                        · Owner: {{ $project->owner->name ?? '—' }}
                                        · Members: {{ $project->members->count() }}
                                    </p>

                                    {{-- Mini progress --}}
                                    <div class="mt-3 flex items-center gap-3">
                                        <div class="flex-1 max-w-xs bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-indigo-500 h-1.5 rounded-full"
                                                style="width: {{ max($progress, 2) }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-indigo-600">{{ $progress }}%</span>
                                    </div>
                                </div>

                                <a href="{{ route('projects.show', $project) }}"
                                    class="inline-flex items-center gap-1.5 self-start sm:self-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition shrink-0">
                                    View
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-12 text-center">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No projects assigned</h3>
                    <p class="text-gray-500 text-sm">Projects will appear here once an admin assigns them to you.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
