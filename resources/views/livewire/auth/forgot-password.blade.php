<div class="w-80 max-w-80 space-y-6">
    <div class="flex justify-center opacity-50">
        <a href="/" class="group flex items-center gap-3">
            <flux:icon.car-front class="size-8 text-black dark:text-white" />
            <span class="text-xl font-semibold text-zinc-800 dark:text-white">Rent a car</span>
        </a>
    </div>
    <flux:heading class="text-center" size="xl">Forgot Password?</flux:heading>

    <form wire:submit.prevent="sendResetLink" class="flex flex-col gap-6">
        @csrf

        <flux:input wire:model="email" label="Email" type="email" placeholder="email@example.com" required />
        <flux:button type="submit" variant="primary" class="w-full" wire:loading.attr="disabled">
            <span wire:loading.remove>Send Reset Link</span>
            <span wire:loading>Sending...</span>
        </flux:button>
    </form>

    <flux:subheading class="text-center">
        <flux:link href="{{ route('login') }}">Back to Sign In</flux:link>
    </flux:subheading>
</div>
