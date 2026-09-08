<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProjectHub — Graduation Project Management</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-white text-gray-900 antialiased">

    {{-- ─── Navbar ─── --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm shadow-indigo-600/30">
                        <span class="text-white font-bold text-xs tracking-tight">PH</span>
                    </div>
                    <span class="font-semibold text-gray-900 text-sm">ProjectHub</span>
                </a>

                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                    <a href="#features" class="hover:text-indigo-600 transition">Features</a>
                    <a href="#how-it-works" class="hover:text-indigo-600 transition">How it works</a>
                    <a href="#about" class="hover:text-indigo-600 transition">About</a>
                    <a href="#contact" class="hover:text-indigo-600 transition">Contact</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition hidden sm:inline">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow-sm shadow-indigo-600/25 transition">
                                Get started
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ─── Hero ─── --}}
    <section class="relative pt-28 pb-20 sm:pt-36 sm:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-indigo-50/80 via-white to-white pointer-events-none"></div>
        <div class="absolute top-20 right-0 w-96 h-96 bg-indigo-100/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-violet-100/30 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/15 mb-6">
                Built for university graduation teams
            </span>

            <h1
                class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900 max-w-4xl mx-auto leading-[1.1]">
                Manage your graduation project
                <span class="text-indigo-600"> in one place</span>
            </h1>

            <p class="mt-6 text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
                ProjectHub replaces scattered WhatsApp chats, Drive folders, and spreadsheets
                with a single platform for students, supervisors, and admins.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-3">
                @guest
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-7 py-3.5 rounded-xl shadow-lg shadow-indigo-600/25 transition">
                            Start free as Student
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endif
                    <a href="{{ route('login') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-3.5 text-sm font-semibold text-gray-700 bg-white ring-1 ring-gray-200 hover:bg-gray-50 rounded-xl transition">
                        Log in
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                        class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-7 py-3.5 rounded-xl shadow-lg shadow-indigo-600/25 transition">
                        Go to Dashboard
                    </a>
                @endguest
            </div>

            {{-- Trust strip --}}
            <div class="mt-14 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-sm text-gray-400">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                            clip-rule="evenodd" />
                    </svg>
                    Tasks & milestones
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                            clip-rule="evenodd" />
                    </svg>
                    Supervisor feedback
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                            clip-rule="evenodd" />
                    </svg>
                    Project health tracking
                </span>
            </div>
        </div>
    </section>

    {{-- ─── Features ─── --}}
    <section id="features" class="py-20 bg-gray-50/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Everything your team needs</h2>
                <p class="mt-3 text-gray-500">From idea to final submission — structured, visible, and supervised.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                    $features = [
                        [
                            'title' => 'Team & ownership',
                            'desc' =>
                                'Create a project, invite up to 5 members, and manage roles with clear ownership rules.',
                            'icon' =>
                                'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
                        ],
                        [
                            'title' => 'Tasks & deadlines',
                            'desc' => 'Assign work, track status, and flag overdue items automatically.',
                            'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        ],
                        [
                            'title' => 'Milestones',
                            'desc' =>
                                'Six default academic milestones from Idea to Final Submission, ready on day one.',
                            'icon' =>
                                'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
                        ],
                        [
                            'title' => 'Secure file sharing',
                            'desc' =>
                                'Upload PDFs and documents privately. Only project members and supervisors can access them.',
                            'icon' =>
                                'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
                        ],
                        [
                            'title' => 'Feedback & evaluation',
                            'desc' => 'Supervisors leave ongoing feedback and submit a clear 0–100 evaluation score.',
                            'icon' =>
                                'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z',
                        ],
                        [
                            'title' => 'Project Health',
                            'desc' =>
                                'Instant Good / Needs Attention / Critical status based on overdue tasks — no guesswork.',
                            'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',
                        ],
                    ];
                @endphp

                @foreach ($features as $f)
                    <div
                        class="bg-white rounded-2xl p-6 ring-1 ring-gray-950/5 hover:ring-indigo-200 transition shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="{{ $f['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">{{ $f['title'] }}</h3>
                        <p class="mt-2 text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── How it works ─── --}}
    <section id="how-it-works" class="py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">How it works</h2>
                <p class="mt-3 text-gray-500">Three roles. One clear workflow.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $steps = [
                        [
                            'role' => 'Student',
                            'color' => 'indigo',
                            'items' => [
                                'Create a project (one per student)',
                                'Build a team of up to 5 members',
                                'Manage tasks, files & milestones',
                                'Track progress and health',
                            ],
                        ],
                        [
                            'role' => 'Supervisor',
                            'color' => 'violet',
                            'items' => [
                                'Monitor assigned projects only',
                                'Change project status workflow',
                                'Leave feedback anytime',
                                'Submit evaluation score (0–100)',
                            ],
                        ],
                        [
                            'role' => 'Admin',
                            'color' => 'emerald',
                            'items' => [
                                'Manage all users & roles',
                                'Activate or deactivate accounts',
                                'Assign supervisors to projects',
                                'View system-wide statistics',
                            ],
                        ],
                    ];
                @endphp

                @foreach ($steps as $i => $step)
                    <div class="relative">
                        <div class="text-5xl font-bold text-gray-100 absolute -top-4 -left-1 select-none">
                            0{{ $i + 1 }}</div>
                        <div class="relative pt-6">
                            <span
                                class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ $step['color'] === 'indigo' ? 'bg-indigo-50 text-indigo-700' : ($step['color'] === 'violet' ? 'bg-violet-50 text-violet-700' : 'bg-emerald-50 text-emerald-700') }}">
                                {{ $step['role'] }}
                            </span>
                            <ul class="mt-4 space-y-2.5">
                                @foreach ($step['items'] as $item)
                                    <li class="flex items-start gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── About ─── --}}
    <section id="about" class="py-20 bg-gray-50/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Built for academic reality</h2>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        Graduation projects often live across WhatsApp groups, Google Drive, email threads,
                        and handwritten notes. ProjectHub centralizes the entire lifecycle — from the first idea
                        to the supervisor’s final evaluation — in one secure web platform.
                    </p>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        Designed as a full-stack Laravel application, it demonstrates real authorization,
                        private file storage, status workflows, and rule-based project health —
                        without unnecessary complexity.
                    </p>
                    <div class="mt-8 grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-white rounded-2xl ring-1 ring-gray-950/5">
                            <p class="text-2xl font-bold text-indigo-600">3</p>
                            <p class="text-xs text-gray-500 mt-1">User roles</p>
                        </div>
                        <div class="text-center p-4 bg-white rounded-2xl ring-1 ring-gray-950/5">
                            <p class="text-2xl font-bold text-indigo-600">6</p>
                            <p class="text-xs text-gray-500 mt-1">Default milestones</p>
                        </div>
                        <div class="text-center p-4 bg-white rounded-2xl ring-1 ring-gray-950/5">
                            <p class="text-2xl font-bold text-indigo-600">5</p>
                            <p class="text-xs text-gray-500 mt-1">Status stages</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl ring-1 ring-gray-950/5 p-8 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">Status workflow</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach (['Planning', 'Analysis', 'Development', 'Testing', 'Completed'] as $s)
                            <span
                                class="px-3 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10">
                                {{ $s }}
                            </span>
                            @if (!$loop->last)
                                <span class="text-gray-300 self-center">→</span>
                            @endif
                        @endforeach
                    </div>
                    <p class="mt-5 text-sm text-gray-500 leading-relaxed">
                        Only the assigned supervisor or admin can advance or correct status —
                        one step at a time — keeping checkpoints meaningful.
                    </p>
                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Project Health
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">Good</span>
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">Needs
                                Attention</span>
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">Critical</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── Contact ─── --}}

    <section id="contact" class="py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Get in touch</h2>
            <p class="mt-3 text-gray-500">Questions about ProjectHub or your graduation project setup?</p>

            @if (session('contact_success'))
                <div
                    class="mt-6 bg-emerald-50 text-emerald-800 text-sm font-medium px-4 py-3 rounded-xl ring-1 ring-emerald-600/20">
                    {{ session('contact_success') }}
                </div>
            @endif

            <div class="mt-10 bg-white rounded-2xl ring-1 ring-gray-950/5 shadow-sm p-8 text-left">
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Your name">
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="you@university.edu">
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                        <textarea name="message" rows="4" required
                            class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="How can we help?">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
                        Send message
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- ─── CTA banner ─── --}}
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-600 to-violet-600 px-8 py-14 text-center shadow-xl shadow-indigo-600/20">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.12),transparent_50%)]">
                </div>
                <div class="relative">
                    <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                        Ready to organize your graduation project?
                    </h2>
                    <p class="mt-3 text-indigo-100 max-w-lg mx-auto text-sm sm:text-base">
                        Register as a student in under a minute and create your first project today.
                    </p>
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="mt-8 inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 text-sm font-semibold px-6 py-3 rounded-xl transition">
                                Create free account
                            </a>
                        @endif
                    @else
                        <a href="{{ url('/dashboard') }}"
                            class="mt-8 inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 text-sm font-semibold px-6 py-3 rounded-xl transition">
                            Open Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    {{-- ─── Footer ─── --}}
    <footer class="border-t border-gray-100 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-[10px]">PH</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">ProjectHub</span>
                </div>
                <p class="text-xs text-gray-400">
                    Graduation Project Management Platform · Built with Laravel
                </p>
                <div class="flex gap-5 text-xs text-gray-400">
                    <a href="#features" class="hover:text-indigo-600 transition">Features</a>
                    <a href="#about" class="hover:text-indigo-600 transition">About</a>
                    <a href="#contact" class="hover:text-indigo-600 transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
