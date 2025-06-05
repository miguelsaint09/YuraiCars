@push('styles')
<style>
    [x-cloak] {
        display: none !important;
    }

    .modal-wrapper {
        position: fixed;
        inset: 0;
        z-index: 9999;
        overflow-y: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 1rem;
    }

    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        z-index: 1;
    }

    .modal-container {
        position: relative;
        width: 100%;
        margin: 2rem auto;
        background: linear-gradient(145deg, 
            rgba(24, 24, 27, 0.98) 0%, 
            rgba(39, 39, 42, 0.95) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        box-shadow: 
            0 25px 50px -12px rgba(0, 0, 0, 0.9),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        overflow: hidden;
        transform-origin: top center;
        z-index: 2;
    }

    .modal-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent,
            rgba(168, 85, 247, 0.7), 
            rgba(99, 102, 241, 0.7),
            transparent);
    }

    /* Animaciones */
    .modal-enter {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-enter-start {
        opacity: 0;
        transform: scale(0.95) translateY(-30px);
    }

    .modal-enter-end {
        opacity: 1;
        transform: scale(1) translateY(0);
    }

    .modal-leave {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-leave-start {
        opacity: 1;
        transform: scale(1) translateY(0);
    }

    .modal-leave-end {
        opacity: 0;
        transform: scale(0.95) translateY(-30px);
    }

    /* Scrollbar personalizado para el modal */
    .modal-container::-webkit-scrollbar {
        width: 8px;
    }

    .modal-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    .modal-container::-webkit-scrollbar-thumb {
        background: rgba(168, 85, 247, 0.5);
        border-radius: 4px;
    }

    .modal-container::-webkit-scrollbar-thumb:hover {
        background: rgba(168, 85, 247, 0.7);
    }
</style>
@endpush

@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    '6xl' => 'sm:max-w-6xl',
    '7xl' => 'sm:max-w-7xl',
][$maxWidth];
@endphp

<div
    x-data="{
        show: @js($show),
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto z-[9999]"
    style="display: none;"
>
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transform transition-all" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    <div class="min-h-screen text-center" @click.self="show = false">
        <div class="fixed inset-0 flex items-center justify-center p-4" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="w-full {{ $maxWidth }} transform overflow-hidden rounded-2xl bg-black/90 text-left align-middle shadow-xl transition-all">
                {{ $slot }}
            </div>
        </div>
    </div>
</div> 