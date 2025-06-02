<div class="relative bg-gradient-to-b min-h-screen flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-4xl bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-8 backdrop-blur-lg bg-opacity-80 dark:bg-opacity-70">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-10">

            <!-- Left: Profile Sidebar -->
            <div class="w-full md:w-1/3 flex flex-col items-center">
                <!-- Profile Avatar -->
                <div class="relative w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-4xl font-bold text-gray-600 dark:text-gray-300 shadow-lg transform transition hover:scale-105">
                    {{ strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1)) ?: 'U' }}
                </div>
                <div class="text-center mt-4">
                    <flux:heading size="xl" class="font-semibold text-gray-800 dark:text-white">
                        {{ $first_name ? "$first_name $last_name" : 'Welcome!' }}
                    </flux:heading>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Right: Profile Info -->
            <div class="w-full md:w-2/3">
                <flux:heading size="xl" class="font-semibold mb-6 text-gray-800 dark:text-white">
                    Profile Information
                </flux:heading>

                @if (session('status'))
                    <div class="text-xs text-center text-green-400 w-full p-2.5 rounded bg-green-100 dark:bg-green-900">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Profile Form -->
                <div class="space-y-6">
                    <flux:input wire:model="first_name" label="First Name" :readonly="!$isEditing" placeholder="Enter first name" />
                    <flux:input wire:model="last_name" label="Last Name" :readonly="!$isEditing" placeholder="Enter last name" />
                    <flux:input wire:model="phone" label="Phone" :readonly="!$isEditing" placeholder="Enter phone number" />
                    <flux:input wire:model="license_number" label="License Number" :readonly="!$isEditing" placeholder="Enter license number" />
                    <flux:input wire:model="date_of_birth" type="date" label="Date of Birth" :readonly="!$isEditing" />

                    <div class="flex justify-end gap-4 pt-4 min-h-[40px]">
                        <flux:button wire:click="saveProfile" variant="primary" class="{{ $isEditing ? '' : 'invisible' }}">Save</flux:button>
                        <flux:button wire:click="toggleEdit" variant="ghost" class="{{ $isEditing ? '' : 'invisible' }}">Cancel</flux:button>
                        @if (!$isEditing)
                            <flux:button icon="file-pen-line" wire:click="toggleEdit" variant="subtle">Edit Profile</flux:button>
                        @endif
                    </div>
                </div>

                <!-- Password Change Section -->
                <livewire:change-password />
            </div>
        </div>
    </div>
</div>

@script
document.addEventListener('livewire:initialized', () => {
    Livewire.on('redirect-to', ({ url }) => {
        window.location.href = url;
    });
});
@endscript