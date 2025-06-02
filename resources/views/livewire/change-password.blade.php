<div class="mt-8 border-t border-neutral-200 dark:border-neutral-700 pt-8">
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl" class="font-semibold text-gray-800 dark:text-white">
            Security Settings
        </flux:heading>
        @if (!$isChangingPassword)
            <flux:button icon="lock-password-line" wire:click="toggleChangePassword" variant="subtle">Change Password</flux:button>
        @endif
    </div>

    @if ($isChangingPassword)
        <div class="space-y-6">
            <flux:input type="password" wire:model="current_password" label="Current Password" placeholder="Enter your current password" />
            <flux:input type="password" wire:model="password" label="New Password" placeholder="Enter your new password" />
            <flux:input type="password" wire:model="password_confirmation" label="Confirm New Password" placeholder="Confirm your new password" />

            <div class="flex justify-end gap-4">
                <flux:button wire:click="changePassword" variant="primary">Update Password</flux:button>
                <flux:button wire:click="toggleChangePassword" variant="ghost">Cancel</flux:button>
            </div>
        </div>
    @endif
</div> 