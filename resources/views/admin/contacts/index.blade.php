<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Contact Messages</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $contacts->total() }} total
                    @if ($unreadCount > 0)
                        · <span class="text-indigo-600 font-medium">{{ $unreadCount }} unread</span>
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('success'))
                <div
                    class="bg-emerald-50 text-emerald-800 text-sm font-medium px-4 py-3 rounded-xl ring-1 ring-emerald-600/20">
                    {{ session('success') }}
                </div>
            @endif

            @if ($contacts->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
                    <div class="divide-y divide-gray-50">
                        @foreach ($contacts as $contact)
                            <div class="p-5 sm:p-6 {{ !$contact->is_read ? 'bg-indigo-50/40' : '' }}">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <p class="font-semibold text-gray-900">{{ $contact->name }}</p>
                                            @if (!$contact->is_read)
                                                <span
                                                    class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide bg-indigo-100 text-indigo-700">
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500">
                                            <a href="mailto:{{ $contact->email }}"
                                                class="text-indigo-600 hover:underline">
                                                {{ $contact->email }}
                                            </a>
                                            · {{ $contact->created_at->format('d M Y H:i') }}
                                        </p>
                                        <p class="mt-3 text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                                            {{ $contact->message }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        @if (!$contact->is_read)
                                            <form method="POST" action="{{ route('admin.contacts.read', $contact) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 px-3 py-1.5 rounded-lg hover:bg-indigo-50 transition">
                                                    Mark read
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
                                            onsubmit="return confirm('Delete this message?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-xs font-medium text-red-500 hover:text-red-700 px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 p-12 text-center">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No messages yet</h3>
                    <p class="text-gray-500 text-sm">Contact form submissions will appear here.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
