<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Manage Users</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $users->total() }} users total</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-1.5 self-start bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create User
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('success'))
                <div
                    class="bg-emerald-50 text-emerald-800 text-sm font-medium px-4 py-3 rounded-xl ring-1 ring-emerald-600/20">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 text-red-700 text-sm font-medium px-4 py-3 rounded-xl ring-1 ring-red-600/20">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-3">
                <select name="role"
                    class="border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="this.form.submit()">
                    <option value="">All roles</option>
                    <option value="student" @selected(request('role') === 'student')>Student</option>
                    <option value="supervisor" @selected(request('role') === 'supervisor')>Supervisor</option>
                    <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                </select>

                <select name="status"
                    class="border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="this.form.submit()">
                    <option value="">All status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>

                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or email..."
                    class="border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full sm:w-56">

                <button type="submit"
                    class="bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold px-4 py-2 rounded-xl ring-1 ring-gray-200 transition">
                    Search
                </button>

                @if (request()->hasAny(['role', 'status', 'q']))
                    <a href="{{ route('admin.users.index') }}"
                        class="text-sm text-gray-500 hover:text-indigo-600 transition">
                        Clear
                    </a>
                @endif
            </form>

            {{-- Table --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr
                                class="border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <th class="px-6 py-3.5">User</th>
                                <th class="px-6 py-3.5">Role</th>
                                <th class="px-6 py-3.5">Status</th>
                                <th class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-semibold shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $user->name }}
                                                    @if ($user->id === auth()->id())
                                                        <span class="text-[10px] text-gray-400 font-normal">(you)</span>
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize
                                            {{ $user->role === 'admin'
                                                ? 'bg-violet-50 text-violet-700 ring-1 ring-violet-600/15'
                                                : ($user->role === 'supervisor'
                                                    ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/15'
                                                    : 'bg-gray-100 text-gray-600 ring-1 ring-gray-200') }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold
                                            {{ $user->is_active
                                                ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/15'
                                                : 'bg-red-50 text-red-700 ring-1 ring-red-600/15' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($user->id !== auth()->id())
                                            <form method="POST"
                                                action="{{ route('admin.users.toggle-active', $user) }}"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg transition
                                                        {{ $user->is_active ? 'text-red-600 hover:bg-red-50' : 'text-emerald-600 hover:bg-emerald-50' }}">
                                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-400">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($users->hasPages())
                <div class="mt-2">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
