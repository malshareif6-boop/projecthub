<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Create User</h2>
            <p class="text-sm text-gray-500 mt-1">Add a supervisor or admin account</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>

                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full
                                name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                autofocus
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Dr. Ahmed">
                            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="ahmed@university.edu">
                            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                            <select id="role" name="role" required
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select role</option>
                                <option value="supervisor" @selected(old('role') === 'supervisor')>Supervisor</option>
                                <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1.5">Students register themselves — only supervisors and
                                admins are created here.</p>
                            <x-input-error :messages="$errors->get('role')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <input id="password" type="password" name="password" required
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1.5">Confirm password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="••••••••">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-1">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                                           text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                                           shadow-sm shadow-indigo-600/25 transition">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
