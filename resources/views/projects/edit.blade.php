<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Project</h2>
            <p class="text-sm text-gray-500 mt-1">Update title and description for <span
                    class="font-medium text-gray-700">{{ $project->title }}</span></p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500"></div>

                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Project Title
                            </label>
                            <input id="title" name="title" type="text" required autofocus
                                value="{{ old('title', $project->title) }}"
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm
                                          focus:border-indigo-500 focus:ring-indigo-500">
                            <x-input-error :messages="$errors->get('title')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Description
                                <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <textarea id="description" name="description" rows="5"
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm
                                             focus:border-indigo-500 focus:ring-indigo-500
                                             placeholder:text-gray-400"
                                placeholder="Describe your project...">{{ old('description', $project->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-1.5" />
                        </div>

                        <div class="rounded-xl bg-gray-50 px-4 py-3 text-xs text-gray-500">
                            Note: Only the project <strong class="text-gray-700">title</strong> and <strong
                                class="text-gray-700">description</strong> can be edited here.
                            Status is controlled by the supervisor.
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-1">
                            <a href="{{ route('projects.show', $project) }}"
                                class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                                           text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                                           shadow-sm shadow-indigo-600/25 transition">
                                Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
