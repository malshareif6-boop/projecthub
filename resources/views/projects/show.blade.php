<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2 text-xs text-[#8A8779]">
                    <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.projects.index' : (auth()->user()->role === 'supervisor' ? 'supervisor.dashboard' : 'projects.index')) }}"
                        class="hover:text-[#1C2333] transition">Projects</a>
                    <span>/</span>
                    <span class="text-[#1C2333]">{{ $project->title }}</span>
                </div>
                <h1 class="font-serif text-2xl text-[#1C2333] mt-1 truncate">{{ $project->title }}</h1>
            </div>
            @can('update', $project)
                <a href="{{ route('projects.edit', $project) }}"
                    class="shrink-0 inline-flex items-center px-4 py-2 bg-white text-[#1C2333] text-sm font-medium rounded-md border border-[#E4E1D6] hover:border-[#1C2333] transition">
                    Edit project
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="min-h-screen" style="background:#FAF9F5">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-2 bg-white text-[#2F4F3D] text-sm font-medium px-4 py-3 rounded-md border border-[#CFE0D3]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4C7A5C]"></span>
                    {{ session('success') }}
                </div>
            @endif

            @php
                $healthDot = match ($health) {
                    'Good' => 'bg-[#4C7A5C]',
                    'Needs Attention' => 'bg-[#B8862E]',
                    default => 'bg-[#B0453A]',
                };
                $healthText = match ($health) {
                    'Good' => 'text-[#2F4F3D]',
                    'Needs Attention' => 'text-[#7A5A1E]',
                    default => 'text-[#7A2E22]',
                };
                $stages = ['planning', 'analysis', 'development', 'testing', 'completed'];
                $stageIndex = array_search($project->status, $stages);
                $stageIndex = $stageIndex === false ? 0 : $stageIndex;
            @endphp

            <div class="lg:flex lg:items-start lg:gap-10" x-data="{ tab: 'overview' }">

                {{-- ============================= MAIN ============================= --}}
                <div class="flex-1 min-w-0">

                    {{-- Tab nav --}}
                    <nav class="flex gap-6 border-b border-[#E4E1D6] overflow-x-auto">
                        <button type="button" @click="tab = 'overview'"
                            :class="tab === 'overview' ? 'border-[#B8862E] text-[#1C2333]' :
                                'border-transparent text-[#8A8779] hover:text-[#1C2333]'"
                            class="shrink-0 pb-3 text-sm font-medium border-b-2 transition">Overview</button>
                        <button type="button" @click="tab = 'tasks'"
                            :class="tab === 'tasks' ? 'border-[#B8862E] text-[#1C2333]' :
                                'border-transparent text-[#8A8779] hover:text-[#1C2333]'"
                            class="shrink-0 pb-3 text-sm font-medium border-b-2 transition">Tasks
                            <span class="text-[#8A8779]">({{ $project->tasks->count() }})</span></button>
                        <button type="button" @click="tab = 'files'"
                            :class="tab === 'files' ? 'border-[#B8862E] text-[#1C2333]' :
                                'border-transparent text-[#8A8779] hover:text-[#1C2333]'"
                            class="shrink-0 pb-3 text-sm font-medium border-b-2 transition">Files
                            <span class="text-[#8A8779]">({{ $project->files->count() }})</span></button>
                        <button type="button" @click="tab = 'feedback'"
                            :class="tab === 'feedback' ? 'border-[#B8862E] text-[#1C2333]' :
                                'border-transparent text-[#8A8779] hover:text-[#1C2333]'"
                            class="shrink-0 pb-3 text-sm font-medium border-b-2 transition">Feedback
                            <span class="text-[#8A8779]">({{ $project->feedbacks->count() }})</span></button>
                        <button type="button" @click="tab = 'milestones'"
                            :class="tab === 'milestones' ? 'border-[#B8862E] text-[#1C2333]' :
                                'border-transparent text-[#8A8779] hover:text-[#1C2333]'"
                            class="shrink-0 pb-3 text-sm font-medium border-b-2 transition">Milestones
                            <span class="text-[#8A8779]">({{ $project->milestones->count() }})</span></button>
                    </nav>

                    {{-- ---------- OVERVIEW ---------- --}}
                    <div x-show="tab === 'overview'" class="pt-6 space-y-6">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="border border-[#E4E1D6] rounded-md p-4 bg-white">
                                <p class="text-xs text-[#8A8779]">Owner</p>
                                <p class="text-sm font-medium text-[#1C2333] mt-1">{{ $project->owner->name ?? '—' }}
                                </p>
                            </div>
                            <div class="border border-[#E4E1D6] rounded-md p-4 bg-white">
                                <p class="text-xs text-[#8A8779]">Supervisor</p>
                                <p class="text-sm font-medium text-[#1C2333] mt-1">
                                    {{ $project->supervisor->name ?? 'Not assigned' }}</p>
                            </div>
                            <div class="border border-[#E4E1D6] rounded-md p-4 bg-white">
                                <p class="text-xs text-[#8A8779]">Created</p>
                                <p class="text-sm font-medium text-[#1C2333] mt-1">
                                    {{ $project->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="border border-[#E4E1D6] rounded-md p-4 bg-white">
                                <p class="text-xs text-[#8A8779]">Overdue tasks</p>
                                <p
                                    class="text-sm font-medium mt-1 {{ $overdueCount > 0 ? 'text-[#B0453A]' : 'text-[#1C2333]' }}">
                                    {{ $overdueCount }}
                                </p>
                            </div>
                        </div>

                        @if ($project->description)
                            <div>
                                <p class="text-xs uppercase tracking-wide text-[#8A8779] mb-2">Description</p>
                                <p class="text-sm text-[#1C2333] leading-relaxed max-w-2xl">{{ $project->description }}
                                </p>
                            </div>
                        @endif

                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <p class="text-xs uppercase tracking-wide text-[#8A8779]">Progress</p>
                                <span class="font-medium text-[#1C2333]">{{ $progress }}%</span>
                            </div>
                            <div class="w-full bg-[#EFEDE4] rounded-full h-1.5 overflow-hidden max-w-md">
                                <div class="bg-[#B8862E] h-1.5 rounded-full transition-all duration-500"
                                    style="width: {{ max($progress, 2) }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- ---------- TASKS ---------- --}}
                    <div x-show="tab === 'tasks'" x-cloak class="pt-6 space-y-4">

                        @if (auth()->id() === $project->owner_id)
                            <div x-data="{ addingTask: false }">
                                <button type="button" @click="addingTask = !addingTask"
                                    class="text-sm font-medium text-[#B8862E] hover:text-[#8A6420] transition">
                                    <span x-show="!addingTask">+ New task</span>
                                    <span x-show="addingTask" x-cloak>Cancel</span>
                                </button>
                                <div x-show="addingTask" x-cloak x-collapse
                                    class="mt-3 border border-[#E4E1D6] rounded-md p-4 bg-white">
                                    <form method="POST" action="{{ route('projects.tasks.store', $project) }}"
                                        class="space-y-3">
                                        @csrf
                                        <input type="text" name="title" placeholder="Task title" required
                                            class="w-full border-[#E4E1D6] rounded-md text-sm shadow-sm focus:border-[#B8862E] focus:ring-[#B8862E]">
                                        <textarea name="description" rows="2" placeholder="Description (optional)"
                                            class="w-full border-[#E4E1D6] rounded-md text-sm shadow-sm focus:border-[#B8862E] focus:ring-[#B8862E]"></textarea>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <select name="assigned_to" required
                                                class="border-[#E4E1D6] rounded-md text-sm shadow-sm">
                                                <option value="">Assign to...</option>
                                                @foreach ($project->members as $member)
                                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="date" name="due_date" required
                                                class="border-[#E4E1D6] rounded-md text-sm shadow-sm">
                                        </div>
                                        <button type="submit"
                                            class="bg-[#1C2333] hover:bg-[#2A3348] text-white text-sm font-medium px-4 py-2 rounded-md transition">
                                            Create task
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        @if ($project->tasks->count() > 0)
                            <div class="border border-[#E4E1D6] rounded-md divide-y divide-[#E4E1D6] bg-white">
                                @foreach ($project->tasks as $task)
                                    @php
                                        $taskDot = match ($task->status) {
                                            'completed' => 'bg-[#4C7A5C]',
                                            'in_progress' => 'bg-[#B8862E]',
                                            default => 'bg-[#B4B2A9]',
                                        };
                                        $isOverdue =
                                            $task->due_date->lt(now()->startOfDay()) && $task->status !== 'completed';
                                    @endphp
                                    <div x-data="{ open: false }">
                                        <button type="button" @click="open = !open"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-[#FAF9F5] transition">
                                            <span class="w-2 h-2 rounded-full shrink-0 {{ $taskDot }}"></span>
                                            <span class="flex-1 min-w-0">
                                                <span
                                                    class="text-sm font-medium text-[#1C2333] truncate block">{{ $task->title }}</span>
                                                <span class="text-xs text-[#8A8779]">
                                                    {{ $task->assignee->name ?? '—' }} · Due
                                                    {{ $task->due_date->format('d M') }}
                                                    @if ($isOverdue)
                                                        <span class="text-[#B0453A] font-medium">· Overdue</span>
                                                    @endif
                                                </span>
                                            </span>
                                            <span
                                                class="hidden sm:flex items-center gap-3 text-xs text-[#8A8779] shrink-0">
                                                <span>{{ $task->files->count() }} files</span>
                                                <span>{{ $task->feedbacks->count() }} notes</span>
                                            </span>
                                            <svg :class="open ? 'rotate-180' : ''"
                                                class="w-4 h-4 text-[#8A8779] transition-transform shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        <div x-show="open" x-cloak x-collapse
                                            class="px-4 pb-5 space-y-4 border-t border-[#F0EEE6]">
                                            @if ($task->description)
                                                <p class="text-sm text-[#5A5850] pt-4">{{ $task->description }}</p>
                                            @endif

                                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                                {{-- Files --}}
                                                <div>
                                                    <h5 class="text-xs uppercase tracking-wide text-[#8A8779] mb-2">
                                                        Files ({{ $task->files->count() }})
                                                    </h5>
                                                    @if ($task->files->count() > 0)
                                                        <ul class="space-y-1.5 mb-3">
                                                            @foreach ($task->files as $file)
                                                                <li
                                                                    class="flex items-center justify-between gap-2 text-sm bg-[#FAF9F5] rounded-md px-3 py-2">
                                                                    <div class="min-w-0">
                                                                        <p class="font-medium text-[#1C2333] truncate">
                                                                            {{ $file->original_name }}</p>
                                                                        <p class="text-xs text-[#8A8779]">
                                                                            {{ $file->uploader->name ?? '—' }} ·
                                                                            {{ number_format($file->size / 1024, 1) }}
                                                                            KB
                                                                        </p>
                                                                    </div>
                                                                    <div class="flex items-center gap-2 shrink-0">
                                                                        <a href="{{ route('task-files.download', $file) }}"
                                                                            class="text-[#B8862E] hover:text-[#8A6420] text-xs font-medium">Download</a>
                                                                        @can('delete', $file)
                                                                            <form method="POST"
                                                                                action="{{ route('task-files.destroy', $file) }}"
                                                                                onsubmit="return confirm('Delete this file?')">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="text-[#B0453A] hover:text-[#7A2E22] text-xs font-medium">Delete</button>
                                                                            </form>
                                                                        @endcan
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="text-xs text-[#8A8779] mb-3">No files yet.</p>
                                                    @endif
                                                    @can('create', [App\Models\TaskFile::class, $task])
                                                        <form method="POST"
                                                            action="{{ route('tasks.files.store', $task) }}"
                                                            enctype="multipart/form-data" class="space-y-2">
                                                            @csrf
                                                            <input type="file" name="file"
                                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required
                                                                class="block w-full text-xs text-[#8A8779] file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-[#F0EEE6] file:text-[#1C2333] hover:file:bg-[#E4E1D6]">
                                                            @error('file')
                                                                <p class="text-xs text-[#B0453A]">{{ $message }}</p>
                                                            @enderror
                                                            <button type="submit"
                                                                class="bg-[#1C2333] hover:bg-[#2A3348] text-white text-xs font-medium px-3 py-1.5 rounded-md transition">Upload</button>
                                                        </form>
                                                    @endcan
                                                </div>

                                                {{-- Feedback --}}
                                                <div>
                                                    <h5 class="text-xs uppercase tracking-wide text-[#8A8779] mb-2">
                                                        Feedback ({{ $task->feedbacks->count() }})
                                                    </h5>
                                                    @if ($task->feedbacks->count() > 0)
                                                        <ul class="space-y-1.5 mb-3 max-h-40 overflow-y-auto">
                                                            @foreach ($task->feedbacks as $feedback)
                                                                <li class="bg-[#FAF9F5] rounded-md px-3 py-2 text-sm">
                                                                    <div
                                                                        class="flex items-start justify-between gap-2">
                                                                        <div class="min-w-0">
                                                                            <p class="text-[#1C2333]">
                                                                                {{ $feedback->message }}</p>
                                                                            <p class="text-xs text-[#8A8779] mt-0.5">
                                                                                {{ $feedback->user->name ?? '—' }} ·
                                                                                {{ $feedback->created_at->format('d M, H:i') }}
                                                                            </p>
                                                                        </div>
                                                                        @can('delete', $feedback)
                                                                            <form method="POST"
                                                                                action="{{ route('task-feedbacks.destroy', $feedback) }}"
                                                                                onsubmit="return confirm('Delete this feedback?')">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="text-[#B0453A] hover:text-[#7A2E22] text-xs font-medium shrink-0">Delete</button>
                                                                            </form>
                                                                        @endcan
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="text-xs text-[#8A8779] mb-3">No feedback yet.</p>
                                                    @endif
                                                    @can('create', [App\Models\TaskFeedback::class, $task])
                                                        <form method="POST"
                                                            action="{{ route('tasks.feedbacks.store', $task) }}"
                                                            class="space-y-2">
                                                            @csrf
                                                            <textarea name="message" rows="2" required placeholder="Write feedback..."
                                                                class="w-full text-sm border-[#E4E1D6] rounded-md shadow-sm focus:border-[#B8862E] focus:ring-[#B8862E]">{{ old('message') }}</textarea>
                                                            @error('message')
                                                                <p class="text-xs text-[#B0453A]">{{ $message }}</p>
                                                            @enderror
                                                            <button type="submit"
                                                                class="bg-[#1C2333] hover:bg-[#2A3348] text-white text-xs font-medium px-3 py-1.5 rounded-md transition">Add
                                                                feedback</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>

                                            <div
                                                class="flex flex-wrap items-center gap-3 pt-3 border-t border-[#F0EEE6]">
                                                @can('update', $task)
                                                    <form method="POST" action="{{ route('tasks.update', $task) }}"
                                                        class="flex gap-2 items-center">
                                                        @csrf
                                                        @method('PUT')
                                                        @if (auth()->id() === $project->owner_id)
                                                            <input type="hidden" name="title"
                                                                value="{{ $task->title }}">
                                                            <input type="hidden" name="description"
                                                                value="{{ $task->description }}">
                                                            <input type="hidden" name="assigned_to"
                                                                value="{{ $task->assigned_to }}">
                                                            <input type="hidden" name="due_date"
                                                                value="{{ $task->due_date->format('Y-m-d') }}">
                                                        @endif
                                                        <select name="status"
                                                            class="border-[#E4E1D6] rounded-md text-xs shadow-sm">
                                                            <option value="pending" @selected($task->status === 'pending')>Pending
                                                            </option>
                                                            <option value="in_progress" @selected($task->status === 'in_progress')>In
                                                                progress</option>
                                                            <option value="completed" @selected($task->status === 'completed')>
                                                                Completed</option>
                                                        </select>
                                                        <button type="submit"
                                                            class="text-xs font-medium text-[#B8862E] hover:text-[#8A6420]">Update
                                                            status</button>
                                                    </form>
                                                @endcan
                                                @can('delete', $task)
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                                        onsubmit="return confirm('Delete this task?')" class="ml-auto">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="text-xs text-[#B0453A] hover:text-[#7A2E22]">Delete
                                                            task</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-[#8A8779]">No tasks yet.</p>
                        @endif
                    </div>

                    {{-- ---------- FILES ---------- --}}
                    <div x-show="tab === 'files'" x-cloak class="pt-6 space-y-4">
                        @php
                            $canUpload =
                                auth()->user()->role === 'admin' ||
                                (auth()->user()->role === 'supervisor' && $project->supervisor_id === auth()->id()) ||
                                $project->members->contains('id', auth()->id());
                        @endphp
                        @if ($canUpload)
                            <form method="POST" action="{{ route('projects.files.store', $project) }}"
                                enctype="multipart/form-data"
                                class="border border-dashed border-[#D8D5C8] rounded-md p-5 bg-white space-y-3">
                                @csrf
                                <input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    required
                                    class="block w-full text-sm text-[#8A8779] file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#F0EEE6] file:text-[#1C2333] hover:file:bg-[#E4E1D6]">
                                <p class="text-xs text-[#8A8779]">PDF, DOC, DOCX, JPG, PNG — max 10 MB</p>
                                <x-input-error :messages="$errors->get('file')" />
                                <button type="submit"
                                    class="bg-[#1C2333] hover:bg-[#2A3348] text-white text-sm font-medium px-5 py-2 rounded-md transition">Upload
                                    file</button>
                            </form>
                        @endif

                        @if ($project->files->count() > 0)
                            <div class="border border-[#E4E1D6] rounded-md divide-y divide-[#E4E1D6] bg-white">
                                @foreach ($project->files as $file)
                                    <div class="flex items-center justify-between px-4 py-3">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-[#1C2333] truncate">
                                                {{ $file->original_name }}</p>
                                            <p class="text-xs text-[#8A8779]">
                                                {{ $file->uploader->name ?? '—' }} ·
                                                {{ number_format($file->size / 1024, 1) }} KB ·
                                                {{ $file->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3 shrink-0">
                                            <a href="{{ route('files.download', $file) }}"
                                                class="text-xs font-medium text-[#B8862E] hover:text-[#8A6420]">Download</a>
                                            @can('delete', $file)
                                                <form method="POST" action="{{ route('files.destroy', $file) }}"
                                                    onsubmit="return confirm('Delete this file?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-[#B0453A] hover:text-[#7A2E22]">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-[#8A8779]">No files uploaded yet.</p>
                        @endif
                    </div>

                    {{-- ---------- FEEDBACK ---------- --}}
                    <div x-show="tab === 'feedback'" x-cloak class="pt-6 space-y-4">
                        @php
                            $canFeedback =
                                auth()->user()->role === 'admin' ||
                                (auth()->user()->role === 'supervisor' && $project->supervisor_id === auth()->id());
                        @endphp
                        @if ($canFeedback)
                            <form method="POST" action="{{ route('projects.feedback.store', $project) }}"
                                class="border border-[#E4E1D6] rounded-md p-4 bg-white space-y-3">
                                @csrf
                                <textarea name="message" rows="3" required placeholder="Write your feedback..."
                                    class="w-full border-[#E4E1D6] rounded-md text-sm shadow-sm focus:border-[#B8862E] focus:ring-[#B8862E]"></textarea>
                                <button type="submit"
                                    class="bg-[#1C2333] hover:bg-[#2A3348] text-white text-sm font-medium px-5 py-2 rounded-md transition">Post
                                    feedback</button>
                            </form>
                        @endif

                        @if ($project->feedbacks->count() > 0)
                            <div class="space-y-3">
                                @foreach ($project->feedbacks as $feedback)
                                    <div class="border border-[#E4E1D6] rounded-md bg-white p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm font-medium text-[#1C2333]">
                                                {{ $feedback->supervisor->name ?? 'Supervisor' }}</p>
                                            <p class="text-xs text-[#8A8779]">
                                                {{ $feedback->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <p class="text-sm text-[#5A5850] whitespace-pre-line">{{ $feedback->message }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-[#8A8779]">No feedback yet.</p>
                        @endif
                    </div>

                    {{-- ---------- MILESTONES ---------- --}}
                    <div x-show="tab === 'milestones'" x-cloak class="pt-6 space-y-3">
                        @forelse ($project->milestones as $milestone)
                            @php
                                $mDot = match ($milestone->status) {
                                    'completed' => 'bg-[#4C7A5C]',
                                    'in_progress' => 'bg-[#B8862E]',
                                    default => 'bg-[#B4B2A9]',
                                };
                            @endphp
                            <div class="border border-[#E4E1D6] rounded-md bg-white p-4">
                                <div class="flex justify-between items-start gap-3">
                                    <div class="flex items-start gap-3">
                                        <span class="w-2 h-2 rounded-full mt-1.5 shrink-0 {{ $mDot }}"></span>
                                        <div>
                                            <p class="text-sm font-medium text-[#1C2333]">{{ $milestone->title }}</p>
                                            <p class="text-xs text-[#8A8779] mt-0.5">Deadline
                                                {{ $milestone->deadline->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="text-[10px] font-medium uppercase tracking-wide text-[#8A8779] shrink-0">
                                        {{ str_replace('_', ' ', $milestone->status) }}
                                    </span>
                                </div>
                                @if (auth()->id() === $project->owner_id)
                                    <form method="POST" action="{{ route('milestones.update', $milestone) }}"
                                        class="mt-3 flex flex-wrap gap-2 items-end pl-5">
                                        @csrf @method('PUT')
                                        <select name="status" class="border-[#E4E1D6] rounded-md text-xs shadow-sm">
                                            <option value="pending" @selected($milestone->status === 'pending')>Pending</option>
                                            <option value="in_progress" @selected($milestone->status === 'in_progress')>In progress
                                            </option>
                                            <option value="completed" @selected($milestone->status === 'completed')>Completed</option>
                                        </select>
                                        <input type="date" name="deadline"
                                            value="{{ $milestone->deadline->format('Y-m-d') }}"
                                            class="border-[#E4E1D6] rounded-md text-xs shadow-sm">
                                        <button type="submit"
                                            class="text-xs font-medium text-[#B8862E] hover:text-[#8A6420]">Update</button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-[#8A8779]">No milestones yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ============================= SIDEBAR ============================= --}}
                <aside class="lg:w-72 shrink-0 mt-10 lg:mt-0 space-y-6">

                    {{-- Status & health --}}
                    <div class="border border-[#E4E1D6] rounded-md bg-white p-4" x-data="{ confirmChange: false }">
                        <p class="text-xs uppercase tracking-wide text-[#8A8779] mb-3">Status</p>
                        <div class="flex items-center justify-between mb-1">
                            @foreach ($stages as $i => $stage)
                                <div class="flex-1 flex items-center">
                                    <span
                                        class="w-2.5 h-2.5 rounded-full shrink-0 {{ $i < $stageIndex ? 'bg-[#4C7A5C]' : ($i === $stageIndex ? 'bg-[#B8862E]' : 'bg-[#E4E1D6]') }}"></span>
                                    @if (!$loop->last)
                                        <span
                                            class="flex-1 h-px {{ $i < $stageIndex ? 'bg-[#4C7A5C]' : 'bg-[#E4E1D6]' }}"></span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm font-medium text-[#1C2333] capitalize mb-3">{{ $project->status }}</p>

                        <div class="flex items-center gap-2 text-sm mb-4">
                            <span class="w-2 h-2 rounded-full {{ $healthDot }}"></span>
                            <span class="{{ $healthText }} font-medium">{{ $health }}</span>
                            <span class="text-[#8A8779]">·
                                @if ($overdueCount > 0)
                                    {{ $overdueCount }} overdue
                                @else
                                    on track
                                @endif
                            </span>
                        </div>

                        @can('changeStatus', $project)
                            <form method="POST" action="{{ route('projects.status.update', $project) }}"
                                class="flex gap-2" @submit.prevent="confirmChange = true">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="flex-1 border-[#E4E1D6] rounded-md text-xs shadow-sm">
                                    @foreach ($stages as $status)
                                        <option value="{{ $status }}" @selected($project->status === $status)>
                                            {{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button type="button" @click="confirmChange = true"
                                    class="shrink-0 bg-[#1C2333] hover:bg-[#2A3348] text-white text-xs font-medium px-3 py-1.5 rounded-md transition">Update</button>
                            </form>
                            <div x-show="confirmChange" x-cloak
                                class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
                                <div class="bg-white rounded-md p-6 max-w-sm w-full shadow-xl"
                                    @click.outside="confirmChange = false">
                                    <h3 class="text-sm font-semibold text-[#1C2333] mb-1">Confirm status change</h3>
                                    <p class="text-sm text-[#8A8779] mb-5">This updates the project stage for everyone on
                                        the team.</p>
                                    <div class="flex gap-3 justify-end">
                                        <button type="button" @click="confirmChange = false"
                                            class="px-4 py-2 text-sm font-medium text-[#1C2333] rounded-md border border-[#E4E1D6] hover:bg-[#FAF9F5]">Cancel</button>
                                        <button type="button"
                                            @click="$el.closest('[x-data]').querySelector('form[method=POST][action*=status]').requestSubmit()"
                                            class="px-4 py-2 text-sm font-medium bg-[#1C2333] text-white rounded-md hover:bg-[#2A3348]">Confirm</button>
                                    </div>
                                </div>
                            </div>
                            @error('status')
                                <p class="text-xs text-[#B0453A] mt-2">{{ $message }}</p>
                            @enderror
                        @endcan
                    </div>

                    {{-- People --}}
                    <div class="border border-[#E4E1D6] rounded-md bg-white p-4">
                        <p class="text-xs uppercase tracking-wide text-[#8A8779] mb-3">People</p>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-6 h-6 rounded-full bg-[#F0EEE6] text-[#1C2333] flex items-center justify-center text-[10px] font-semibold shrink-0">
                                    {{ strtoupper(substr($project->owner->name ?? '—', 0, 1)) }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[#1C2333] truncate">{{ $project->owner->name ?? '—' }}</p>
                                    <p class="text-xs text-[#8A8779]">Owner</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-6 h-6 rounded-full bg-[#F0EEE6] text-[#1C2333] flex items-center justify-center text-[10px] font-semibold shrink-0">
                                    {{ $project->supervisor ? strtoupper(substr($project->supervisor->name, 0, 1)) : '—' }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[#1C2333] truncate">
                                        {{ $project->supervisor->name ?? 'Not assigned' }}</p>
                                    <p class="text-xs text-[#8A8779]">Supervisor</p>
                                </div>
                            </div>
                        </div>

                        @if (auth()->user()->role === 'admin')
                            <form method="POST" action="{{ route('projects.assign-supervisor', $project) }}"
                                class="mt-4 pt-4 border-t border-[#F0EEE6] space-y-2">
                                @csrf
                                @method('PATCH')
                                <select name="supervisor_id"
                                    class="w-full border-[#E4E1D6] rounded-md text-xs shadow-sm" required>
                                    <option value="">Assign supervisor</option>
                                    @foreach (\App\Models\User::where('role', 'supervisor')->where('is_active', true)->get() as $supervisor)
                                        <option value="{{ $supervisor->id }}" @selected($project->supervisor_id === $supervisor->id)>
                                            {{ $supervisor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="w-full bg-[#1C2333] hover:bg-[#2A3348] text-white text-xs font-medium px-3 py-1.5 rounded-md transition">Save</button>
                            </form>
                        @endif
                    </div>

                    {{-- Team --}}
                    <div class="border border-[#E4E1D6] rounded-md bg-white p-4">
                        <p class="text-xs uppercase tracking-wide text-[#8A8779] mb-3">Team
                            ({{ $project->members->count() }}/5)</p>
                        <ul class="space-y-2">
                            @foreach ($project->members as $member)
                                <li class="flex items-center justify-between gap-2 text-sm">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span
                                            class="w-6 h-6 rounded-full bg-[#F0EEE6] text-[#1C2333] flex items-center justify-center text-[10px] font-semibold shrink-0">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </span>
                                        <span class="text-[#1C2333] truncate">{{ $member->name }}</span>
                                        @if ($member->id === $project->owner_id)
                                            <span
                                                class="text-[9px] font-semibold uppercase tracking-wide bg-[#F0EEE6] text-[#8A8779] px-1.5 py-0.5 rounded shrink-0">Owner</span>
                                        @endif
                                    </div>
                                    @if (auth()->id() === $project->owner_id && $member->id !== $project->owner_id)
                                        <form method="POST"
                                            action="{{ route('projects.members.destroy', [$project, $member]) }}"
                                            onsubmit="return confirm('Remove this member?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-xs text-[#B0453A] hover:text-[#7A2E22] shrink-0">Remove</button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @if (auth()->id() === $project->owner_id && $project->members->count() < 5)
                            <form method="POST" action="{{ route('projects.members.store', $project) }}"
                                class="mt-3 pt-3 border-t border-[#F0EEE6] flex gap-2">
                                @csrf
                                <input type="email" name="email" placeholder="Student email" required
                                    class="flex-1 border-[#E4E1D6] rounded-md text-xs shadow-sm focus:border-[#B8862E] focus:ring-[#B8862E]">
                                <button type="submit"
                                    class="shrink-0 bg-[#1C2333] hover:bg-[#2A3348] text-white text-xs font-medium px-3 py-1.5 rounded-md transition">Add</button>
                            </form>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        @endif
                    </div>

                    {{-- Evaluation --}}
                    <div class="border border-[#E4E1D6] rounded-md bg-white p-4">
                        <p class="text-xs uppercase tracking-wide text-[#8A8779] mb-3">Evaluation</p>
                        @if ($project->evaluation)
                            <p class="font-serif text-3xl text-[#1C2333]">{{ $project->evaluation->score }}<span
                                    class="text-base text-[#B4B2A9]">/100</span></p>
                            @if ($project->evaluation->comment)
                                <p class="text-sm text-[#5A5850] mt-2">{{ $project->evaluation->comment }}</p>
                            @endif
                            <p class="text-xs text-[#8A8779] mt-2">
                                {{ $project->evaluation->supervisor->name ?? '—' }} ·
                                {{ $project->evaluation->updated_at->format('d M Y') }}
                            </p>
                        @else
                            <p class="text-sm text-[#8A8779]">Not yet evaluated.</p>
                        @endif

                        @php
                            $canEvaluate =
                                auth()->user()->role === 'admin' ||
                                (auth()->user()->role === 'supervisor' && $project->supervisor_id === auth()->id());
                        @endphp
                        @if ($canEvaluate)
                            <form method="POST" action="{{ route('projects.evaluation.store', $project) }}"
                                class="mt-4 pt-4 border-t border-[#F0EEE6] space-y-2">
                                @csrf
                                <input type="number" name="score" min="0" max="100" required
                                    placeholder="Score (0–100)"
                                    value="{{ old('score', $project->evaluation->score ?? '') }}"
                                    class="w-full border-[#E4E1D6] rounded-md text-xs shadow-sm focus:border-[#B8862E] focus:ring-[#B8862E]">
                                <textarea name="comment" rows="2" placeholder="Comment (optional)"
                                    class="w-full border-[#E4E1D6] rounded-md text-xs shadow-sm focus:border-[#B8862E] focus:ring-[#B8862E]">{{ old('comment', $project->evaluation->comment ?? '') }}</textarea>
                                <button type="submit"
                                    class="w-full bg-[#1C2333] hover:bg-[#2A3348] text-white text-xs font-medium px-3 py-1.5 rounded-md transition">
                                    {{ $project->evaluation ? 'Update evaluation' : 'Submit evaluation' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>

    {{--
        =====================================================================
        NO-RELOAD UPDATES — Turbo Drive
        =====================================================================
        Every form on this page updates WITHOUT a full browser page reload,
        with ZERO changes to any Controller. Turbo intercepts submits/links,
        sends them via fetch(), follows the normal redirect()->back()
        response, and morphs the returned HTML into the current DOM instead
        of doing a full page replace (since the URL is unchanged).
    --}}
    <script>
        (function() {
            function ensureMeta(name, content) {
                if (!document.querySelector('meta[name="' + name + '"]')) {
                    var meta = document.createElement('meta');
                    meta.name = name;
                    meta.content = content;
                    document.head.appendChild(meta);
                }
            }
            ensureMeta('turbo-refresh-method', 'morph');
            ensureMeta('turbo-refresh-scroll', 'preserve');
        })();
    </script>
    <script type="module">
        import * as Turbo from "https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/+esm";
    </script>
</x-app-layout>
