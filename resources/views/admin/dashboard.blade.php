<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Admin Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">System overview and management</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Students</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['students'] }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Supervisors</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['supervisors'] }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Projects</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['projects'] }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Completed</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $stats['completed'] }}</p>
                </div>

            </div>

            {{-- Quick actions --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        Manage Users
                    </a>
                    <a href="{{ route('admin.projects.index') }}"
                        class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl ring-1 ring-gray-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        All Projects
                    </a>
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-xl ring-1 ring-gray-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Create User
                    </a>
                </div>
            </div>

            {{-- Recent Projects --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Recent Projects</h3>
                    <a href="{{ route('admin.projects.index') }}"
                        class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                        View all
                    </a>
                </div>

                @if ($recentProjects->count() > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach ($recentProjects as $project)
                            <a href="{{ route('projects.show', $project) }}"
                                class="flex items-center justify-between px-6 py-4 hover:bg-gray-50/80 transition group">
                                <div class="min-w-0">
                                    <p
                                        class="font-medium text-gray-900 group-hover:text-indigo-600 transition truncate">
                                        {{ $project->title }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-0.5">
                                        <span class="capitalize">{{ $project->status }}</span>
                                        · {{ $project->owner->name ?? '—' }}
                                        · {{ $project->supervisor->name ?? 'No supervisor' }}
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 transition shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-10 text-center text-sm text-gray-400">
                        No projects yet.
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
