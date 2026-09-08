<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                Welcome back, {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">Here's an overview of your graduation project</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @php
                $project = auth()
                    ->user()
                    ->projects()
                    ->with(['supervisor', 'members', 'tasks', 'evaluation'])
                    ->first();
            @endphp

            @if ($project)
                @php
                    $progress = app(\App\Services\ProgressCalculator::class)->calculate($project);
                    $health = app(\App\Services\ProjectHealthCalculator::class)->calculate($project);
                    $healthClasses = match ($health) {
                        'Good' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                        'Needs Attention' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                        default => 'bg-red-50 text-red-700 ring-red-600/20',
                    };
                @endphp

                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
                    {{-- Gradient header --}}
                    <div class="bg-gradient-to-br from-indigo-600 via-indigo-600 to-violet-600 px-6 py-6">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <p class="text-indigo-200 text-xs font-medium uppercase tracking-wider">Your Project</p>
                                <h3 class="text-xl font-bold text-white mt-1">{{ $project->title }}</h3>
                            </div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ring-1 ring-inset {{ $healthClasses }} bg-white/95 shrink-0">
                                {{ $health }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        {{-- Meta row --}}
                        <div class="flex flex-wrap gap-x-5 gap-y-2 text-sm">
                            <div class="flex items-center gap-1.5 text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                Status: <strong class="text-gray-800 capitalize">{{ $project->status }}</strong>
                            </div>
                            <div class="flex items-center gap-1.5 text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                Supervisor: <strong
                                    class="text-gray-800">{{ $project->supervisor->name ?? 'Not assigned' }}</strong>
                            </div>
                            <div class="flex items-center gap-1.5 text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                Team: <strong class="text-gray-800">{{ $project->members->count() }}/5</strong>
                            </div>
                        </div>

                        {{-- Progress --}}
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-medium text-gray-700">Progress</span>
                                <span class="font-bold text-indigo-600">{{ $progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-violet-500 h-2.5 rounded-full transition-all duration-500"
                                    style="width: {{ max($progress, 2) }}%"></div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                            <div>
                                @if ($project->evaluation)
                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Evaluation</p>
                                    <p class="text-2xl font-bold text-gray-900 mt-0.5">
                                        {{ $project->evaluation->score }}
                                        <span class="text-sm font-normal text-gray-400">/100</span>
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400">Not yet evaluated</p>
                                @endif
                            </div>
                            <a href="{{ route('projects.show', $project) }}"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
                                View Project
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @else
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
            @endif

        </div>
    </div>
</x-app-layout>
