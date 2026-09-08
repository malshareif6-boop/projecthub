<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Create New Project</h2>
            <p class="text-sm text-gray-500 mt-1">Start your graduation project journey</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
                {{-- Top accent --}}
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>

                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('projects.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Project Title
                            </label>
                            <input id="title" name="title" type="text" required autofocus
                                value="{{ old('title') }}" placeholder="e.g. Smart Campus Navigation System"
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm
                                          focus:border-indigo-500 focus:ring-indigo-500
                                          placeholder:text-gray-400">
                            <x-input-error :messages="$errors->get('title')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Description
                                <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <textarea id="description" name="description" rows="5"
                                placeholder="Briefly describe your project idea, goals, and scope..."
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm
                                             focus:border-indigo-500 focus:ring-indigo-500
                                             placeholder:text-gray-400">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-1.5" />
                        </div>

                        <div class="rounded-xl bg-indigo-50/60 px-4 py-3 text-sm text-indigo-800">
                            <p class="font-medium">What happens next?</p>
                            <ul class="mt-1.5 space-y-1 text-indigo-700/80 text-xs list-disc list-inside">
                                <li>You become the project owner</li>
                                <li>6 default milestones are created automatically</li>
                                <li>Status starts as <strong>Planning</strong></li>
                                <li>You can invite up to 4 more team members</li>
                            </ul>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-1">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                                           text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                                           shadow-sm shadow-indigo-600/25 transition">
                                Create Project
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
