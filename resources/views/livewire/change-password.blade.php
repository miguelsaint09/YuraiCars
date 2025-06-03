<div class="mt-8 border-t border-neutral-200 dark:border-neutral-700 pt-8">
    @if (!$isChangingPassword)
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="lg" class="text-gray-800 dark:text-white">Cambio de Contraseña</flux:heading>
                <p class="text-sm text-gray-600 dark:text-gray-400">Actualiza tu contraseña de manera segura</p>
            </div>
            <flux:button wire:click="toggleChangePassword" variant="subtle">Cambiar Contraseña</flux:button>
        </div>
    @else
        <div class="space-y-4">
            <flux:heading size="lg" class="text-gray-800 dark:text-white">Cambiar Contraseña</flux:heading>
            <flux:input wire:model="current_password" type="password" label="Contraseña Actual" required />
            <flux:input wire:model="password" type="password" label="Nueva Contraseña" required />
            <flux:input wire:model="password_confirmation" type="password" label="Confirmar Nueva Contraseña" required />
            <div class="flex justify-end gap-4">
                <flux:button wire:click="changePassword" variant="primary">Actualizar Contraseña</flux:button>
                <flux:button wire:click="toggleChangePassword" variant="ghost">Cancelar</flux:button>
            </div>
        </div>
    @endif
</div>