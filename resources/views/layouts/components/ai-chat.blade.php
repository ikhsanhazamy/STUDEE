<div
    id="ai-chat-widget"
    class="fixed bottom-5 right-5 z-50"
    data-chat-url="{{ route('ai.chat') }}"
>
    <section
        id="ai-chat-panel"
        class="hidden w-[min(92vw,380px)] overflow-hidden rounded-2xl border border-white/30 bg-[#E7EFC7] shadow-2xl"
        aria-label="STUDEE AI chat"
    >
        <header class="flex items-center justify-between gap-3 bg-[#3B3B1A] px-4 py-3 text-white">
            <div class="min-w-0">
                <h2 class="text-sm font-bold">STUDEE AI</h2>
                <p class="text-xs text-white/70">Tanya jawab umum</p>
            </div>
            <button
                type="button"
                id="ai-chat-close"
                class="grid h-9 w-9 place-items-center rounded-full bg-white/10 text-lg font-bold transition hover:bg-white/20"
                aria-label="Tutup chat AI"
            >
                x
            </button>
        </header>

        <div
            id="ai-chat-messages"
            class="flex h-80 flex-col gap-3 overflow-y-auto px-4 py-4"
            aria-live="polite"
        >
            <div class="max-w-[84%] rounded-2xl rounded-bl-md bg-white px-4 py-3 text-sm text-[#3B3B1A] shadow">
                Halo! Mau tanya apa saja? Aku bisa bantu jawab pertanyaan umum.
            </div>
        </div>

        <form id="ai-chat-form" class="border-t border-[#3B3B1A]/10 bg-white/60 p-3">
            <label for="ai-chat-input" class="sr-only">Tulis pertanyaan</label>
            <div class="flex items-end gap-2">
                <textarea
                    id="ai-chat-input"
                    class="max-h-32 min-h-11 flex-1 resize-none rounded-xl border-[#8A784E]/30 bg-white px-3 py-2 text-sm text-[#3B3B1A] shadow-sm focus:border-[#8A784E] focus:ring-[#8A784E]"
                    rows="1"
                    maxlength="2000"
                    placeholder="Tanya AI..."
                    required
                ></textarea>
                <button
                    type="submit"
                    id="ai-chat-submit"
                    class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-[#8A784E] text-lg font-black text-[#E7EFC7] shadow transition hover:bg-[#7A6A45] disabled:cursor-not-allowed disabled:opacity-60"
                    aria-label="Kirim pertanyaan"
                >
                    &gt;
                </button>
            </div>
        </form>
    </section>

    <button
        type="button"
        id="ai-chat-open"
        class="mt-3 flex items-center gap-3 rounded-full bg-[#3B3B1A] px-4 py-3 text-white shadow-2xl transition hover:-translate-y-0.5 hover:bg-[#4B4B25]"
        aria-label="Buka chat AI"
    >
        <span class="grid h-9 w-9 place-items-center rounded-full bg-[#E7EFC7] text-sm font-black text-[#3B3B1A]">AI</span>
        <span class="text-sm font-bold">Tanya AI</span>
    </button>
</div>
