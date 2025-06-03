<div class="w-80 max-w-80 space-y-6">
    <div class="flex justify-center opacity-50">
        <a href="/" class="group flex items-center gap-3">
            <flux:icon.car-front class="size-8 text-black dark:text-white" />
            <span class="text-xl font-semibold text-zinc-800 dark:text-white">Alquiler de Autos</span>
        </a>
    </div>
    <flux:heading class="text-center" size="xl">Restablecer Contraseña</flux:heading>

    <form wire:submit.prevent="resetPassword" class="flex flex-col gap-6">
        @csrf
        <input type="hidden" wire:model="token">
        <flux:input wire:model="email" label="Correo Electrónico" type="email" placeholder="correo@ejemplo.com" readonly />
        <flux:input wire:model="password" label="Nueva Contraseña" type="password" placeholder="Tu nueva contraseña" required />
        <flux:input wire:model="password_confirmation" label="Confirmar Contraseña" type="password" placeholder="Confirma tu contraseña" required />

        <flux:button type="submit" variant="primary" class="w-full" wire:loading.attr="disabled">
            <span wire:loading.remove>Restablecer Contraseña</span>
            <span wire:loading>Procesando...</span>
        </flux:button>
    </form>
</div>
