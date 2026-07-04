{{--
    Toast Global Component
    ========================
    Mount di layouts/app.blade.php dengan: <x-toast />

    Trigger via JS:
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message: 'Pesan sukses!', type: 'success' }
        }));

    Atau via session (letakkan inline script setelah komponen ini):
        @if(session('success'))
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: "{{ session('success') }}", type: 'success' } }));
        @endif
--}}

<div
    x-data="{
        toasts: [],
        show(detail) {
            const toast = { message: detail.message, type: detail.type || 'success', id: Date.now() };
            this.toasts.push(toast);
            setTimeout(() => {
                this.dismiss(toast.id);
            }, 3500);
        },
        dismiss(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @toast.window="show($event.detail)"
    class="toast-container position-fixed bottom-0 end-0 p-3"
    style="z-index: 1090;"
    aria-live="polite"
    aria-atomic="true"
>
    <template x-for="t in toasts" :key="t.id">
        <div
            class="toast show mb-2 border-0 shadow"
            :class="t.type === 'error' ? 'toast--error' : 'toast--success'"
            role="alert"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            style="min-width: 280px; max-width: 360px; border-radius: 12px; overflow: hidden;"
        >
            <div class="toast-body d-flex align-items-center justify-content-between gap-2 px-3 py-3">
                <div class="d-flex align-items-center gap-2">
                    {{-- Icon: check for success, x-circle for error --}}
                    <span
                        class="toast-icon d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                        :class="t.type === 'error' ? 'toast-icon--error' : 'toast-icon--success'"
                        style="width: 28px; height: 28px;"
                    >
                        <i
                            class="fas fa-sm"
                            :class="t.type === 'error' ? 'fa-times-circle' : 'fa-check-circle'"
                        ></i>
                    </span>

                    <span class="toast-message fw-medium small" x-text="t.message" style="font-family: var(--font-body, 'Montserrat', sans-serif);"></span>
                </div>

                {{-- Close button --}}
                <button
                    type="button"
                    class="btn-close btn-close-sm flex-shrink-0"
                    :class="t.type === 'error' ? '' : 'toast-close--pink'"
                    @click="dismiss(t.id)"
                    aria-label="Tutup notifikasi"
                    style="opacity: 0.6;"
                ></button>
            </div>

            {{-- Progress bar (auto-dismiss indicator) --}}
            <div
                class="toast-progress"
                :class="t.type === 'error' ? 'toast-progress--error' : 'toast-progress--success'"
                style="height: 3px; animation: toastProgress 3.5s linear forwards;"
            ></div>
        </div>
    </template>
</div>

<style>
    /* =====================
       Toast Theme Colors
    ===================== */
    .toast--success {
        background: #fff;
        border-left: 4px solid #16A34A !important;
    }

    .toast--error {
        background: #fff;
        border-left: 4px solid #DC2626 !important;
    }

    .toast-icon--success {
        background: rgba(22, 163, 74, 0.15);
        color: #16A34A;
    }

    .toast-icon--error {
        background: rgba(220, 38, 38, 0.12);
        color: #DC2626;
    }

    .toast-message {
        color: #1a1a1a;
        line-height: 1.4;
    }

    /* Pink-tinted close button for success toasts */
    .toast-close--pink {
        filter: sepia(1) saturate(3) hue-rotate(290deg) brightness(0.6);
    }

    /* Progress bar animation */
    .toast-progress--success {
        background: #16A34A;
        width: 100%;
        transform-origin: left;
    }

    .toast-progress--error {
        background: #DC2626;
        width: 100%;
        transform-origin: left;
    }

    @keyframes toastProgress {
        from { width: 100%; }
        to   { width: 0%; }
    }

    /* Smooth slide-in on mobile too */
    @media (max-width: 576px) {
        .toast-container {
            left: 0.75rem !important;
            right: 0.75rem !important;
        }

        .toast-container .toast {
            min-width: unset !important;
            max-width: 100% !important;
            width: 100%;
        }
    }
</style>
