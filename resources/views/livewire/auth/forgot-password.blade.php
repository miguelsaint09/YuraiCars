<div class="w-80 max-w-80 space-y-6">
    <div class="flex justify-center opacity-50">
        <a href="/" class="group flex items-center gap-3">
            <flux:icon.car-front class="size-8 text-black dark:text-white" />
            <span class="text-xl font-semibold text-zinc-800 dark:text-white">Alquiler de Autos</span>
        </a>
    </div>
    <flux:heading class="text-center" size="xl">¿Olvidaste tu Contraseña?</flux:heading>

    <form wire:submit.prevent="sendResetLink" class="flex flex-col gap-6">
        @csrf
        <flux:input wire:model="email" label="Correo Electrónico" type="email" placeholder="correo@ejemplo.com" required />
        <flux:button type="submit" variant="primary" class="w-full" wire:loading.attr="disabled">
            <span wire:loading.remove>Enviar Link de Recuperación</span>
            <span wire:loading>Enviando...</span>
        </flux:button>
    </form>

    <flux:subheading class="text-center">
        <flux:link href="{{ route('login') }}">Volver al Inicio de Sesión</flux:link>
    </flux:subheading>
</div>
