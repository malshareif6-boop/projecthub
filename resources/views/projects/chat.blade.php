<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $type === 'team' ? 'Team Chat' : 'Supervisor Chat' }}
                </h2>
                <p class="text-sm text-gray-500">{{ $project->title }}</p>
            </div>
            <a href="{{ route('projects.show', $project) }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to
                project</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden flex flex-col" style="height: 70vh"
                id="chat-root" data-conversation-id="{{ $conversation->id }}" data-user-id="{{ auth()->id() }}"
                data-store-url="{{ route('messages.store', $conversation) }}" data-csrf="{{ csrf_token() }}"
                x-data="chatApp()" x-init="init()">

                <script type="application/json" id="initial-messages">
    @json($messagesJson)
</script>

                <div class="flex-1 overflow-y-auto p-4 space-y-3" x-ref="list">
                    <template x-for="msg in messages" :key="msg.id">
                        <div class="flex" :class="msg.user_id === currentUserId ? 'justify-end' : 'justify-start'">
                            <div class="max-w-[75%] rounded-2xl px-4 py-2 text-sm"
                                :class="msg.user_id === currentUserId ?
                                    'bg-indigo-600 text-white' :
                                    'bg-gray-100 text-gray-800'">
                                <p class="text-xs opacity-70 mb-0.5" x-text="msg.user_name"
                                    x-show="msg.user_id !== currentUserId"></p>
                                <p class="whitespace-pre-wrap" x-text="msg.body"></p>
                                <p class="text-[10px] opacity-60 mt-1" x-text="formatTime(msg.created_at)"></p>
                            </div>
                        </div>
                    </template>
                    <p x-show="messages.length === 0" class="text-center text-gray-400 text-sm py-8">
                        No messages yet. Say hello!
                    </p>
                </div>

                <form @submit.prevent="send" class="border-t p-3 flex gap-2">
                    <input type="text" x-model="text" maxlength="2000" placeholder="Type a message..."
                        class="flex-1 border-gray-300 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        :disabled="sending" required>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-xl disabled:opacity-50"
                        :disabled="sending || !text.trim()">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function chatApp() {
            const root = document.getElementById('chat-root');
            const initial = JSON.parse(
                document.getElementById('initial-messages').textContent || '[]'
            );

            return {
                messages: initial,
                text: '',
                sending: false,
                currentUserId: Number(root.dataset.userId),
                conversationId: Number(root.dataset.conversationId),
                storeUrl: root.dataset.storeUrl,
                csrf: root.dataset.csrf,

                // init() {
                //     this.$nextTick(() => this.scrollBottom());

                //     if (typeof window.Echo === 'undefined') {
                //         console.warn('Echo not loaded — live updates disabled');
                //         return;
                //     }

                //     window.Echo.private('conversation.' + this.conversationId)
                //         .listen('.MessageSent', (e) => {
                //             if (this.messages.some(m => m.id === e.id)) return;
                //             this.messages.push(e);
                //             this.$nextTick(() => this.scrollBottom());
                //         });
                // },
                init() {
                    this.$nextTick(() => this.scrollBottom());

                    if (typeof window.Echo === 'undefined') {
                        console.error('Echo not loaded');
                        return;
                    }

                    console.log('Echo OK, subscribing to conversation.' + this.conversationId);

                    window.Echo.private('conversation.' + this.conversationId)
                        .subscribed(() => {
                            console.log('SUBSCRIBED to private channel');
                        })
                        .error((err) => {
                            console.error('CHANNEL ERROR', err);
                        })
                        .listen('.MessageSent', (e) => {
                            console.log('EVENT RECEIVED', e);
                            if (this.messages.some(m => m.id === e.id)) return;
                            this.messages.push(e);
                            this.$nextTick(() => this.scrollBottom());
                        });
                },

                async send() {
                    if (!this.text.trim() || this.sending) return;
                    this.sending = true;
                    const payload = this.text.trim();
                    this.text = '';

                    try {
                        const res = await fetch(this.storeUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrf,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                body: payload
                            }),
                        });

                        if (!res.ok) {
                            console.error(res.status, await res.text());
                            throw new Error('send failed');
                        }

                        const data = await res.json();
                        if (!this.messages.some(m => m.id === data.id)) {
                            this.messages.push(data);
                        }
                        this.$nextTick(() => this.scrollBottom());
                    } catch (e) {
                        this.text = payload;
                        alert('Could not send message.');
                    } finally {
                        this.sending = false;
                    }
                },

                scrollBottom() {
                    const el = this.$refs.list;
                    if (el) el.scrollTop = el.scrollHeight;
                },

                formatTime(iso) {
                    try {
                        return new Date(iso).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit',
                        });
                    } catch {
                        return '';
                    }
                },
            };
        }
    </script>
</x-app-layout>
