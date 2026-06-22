const chatWidget = document.getElementById('ai-chat-widget');

if (chatWidget) {
    const panel = document.getElementById('ai-chat-panel');
    const openButton = document.getElementById('ai-chat-open');
    const closeButton = document.getElementById('ai-chat-close');
    const form = document.getElementById('ai-chat-form');
    const input = document.getElementById('ai-chat-input');
    const submitButton = document.getElementById('ai-chat-submit');
    const messagesEl = document.getElementById('ai-chat-messages');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const history = [];

    const setOpen = (isOpen) => {
        panel.classList.toggle('hidden', !isOpen);
        openButton.classList.toggle('hidden', isOpen);

        if (isOpen) {
            input.focus();
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }
    };

    const appendMessage = (role, content) => {
        const bubble = document.createElement('div');
        bubble.className = role === 'user'
            ? 'ml-auto max-w-[84%] rounded-2xl rounded-br-md bg-[#8A784E] px-4 py-3 text-sm text-[#E7EFC7] shadow'
            : 'max-w-[84%] rounded-2xl rounded-bl-md bg-white px-4 py-3 text-sm text-[#3B3B1A] shadow';
        bubble.textContent = content;
        messagesEl.appendChild(bubble);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return bubble;
    };

    const setLoading = (isLoading) => {
        input.disabled = isLoading;
        submitButton.disabled = isLoading;
    };

    openButton.addEventListener('click', () => setOpen(true));
    closeButton.addEventListener('click', () => setOpen(false));

    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = `${input.scrollHeight}px`;
    });

    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            form.requestSubmit();
        }
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = input.value.trim();

        if (!message) {
            return;
        }

        appendMessage('user', message);
        input.value = '';
        input.style.height = 'auto';

        const thinkingBubble = appendMessage('assistant', 'Sedang berpikir...');
        setLoading(true);

        try {
            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }

            const response = await fetch(chatWidget.dataset.chatUrl, {
                method: 'POST',
                headers,
                body: JSON.stringify({
                    message,
                    history: history.slice(-8),
                }),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'AI belum bisa menjawab.');
            }

            thinkingBubble.textContent = data.answer;
            history.push({ role: 'user', content: message });
            history.push({ role: 'assistant', content: data.answer });
        } catch (error) {
            thinkingBubble.textContent = error.message || 'Terjadi kesalahan saat menghubungi AI.';
        } finally {
            setLoading(false);
            input.focus();
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }
    });
}
