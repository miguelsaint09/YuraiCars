<div class="w-80 max-w-80 space-y-6">
    <div class="flex justify-center opacity-50">
        <a href="/" class="group flex items-center gap-3">
            <flux:icon.car-front class="size-8 text-black dark:text-white" />
            <span class="text-xl font-semibold text-zinc-800 dark:text-white">Rent a car</span>
        </a>
    </div>
    <flux:heading class="text-center" size="xl">Reset Password</flux:heading>

    <form wire:submit.prevent="resetPassword" class="flex flex-col gap-6">
        @csrf

        <input type="hidden" wire:model="token">
        <flux:input wire:model="email" label="Email" type="email" placeholder="email@example.com" readonly />
        <flux:input wire:model="password" label="New Password" type="password" placeholder="Your new password" required />
        <flux:input wire:model="password_confirmation" label="Confirm Password" type="password" placeholder="Confirm your password" required />

        <flux:button type="submit" variant="primary" class="w-full" wire:loading.attr="disabled">
            <span wire:loading.remove>Reset Password</span>
            <span wire:loading>Processing...</span>
        </flux:button>
    </form>
</div>
