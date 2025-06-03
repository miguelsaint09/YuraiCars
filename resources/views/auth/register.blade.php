<x-layouts.auth title="Registro">
    <div class="flex min-h-screen">
        <div class="flex-1 flex justify-center items-center">
            <div class="w-80 max-w-80 space-y-6">
                <div class="flex justify-center opacity-50">
                    <a href="/" class="group flex items-center gap-3">
                        <flux:icon.car-front class="size-8 text-black dark:text-white" />
                        <span class="text-xl font-semibold text-zinc-800 dark:text-white">YuraiCars</span>
                    </a>
                </div>

                <flux:heading class="text-center" size="xl">Registra tu Cuenta</flux:heading>

                <flux:separator />

                <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-6">
                    @csrf

                    <flux:input name="email" label="Correo Electrónico" type="email" placeholder="correo@ejemplo.com" value="{{ old('email') }}" />

                    <flux:field>
                        <div class="mb-3 flex justify-between">
                            <flux:label>Contraseña</flux:label>
                        </div>
                        <flux:input name="password" type="password" placeholder="Tu contraseña" />
                    </flux:field>

                    <flux:button type="submit" variant="primary" class="w-full">Registrarse</flux:button>
                </form>
    
                <flux:subheading class="text-center">
                    ¿Ya tienes una cuenta? <flux:link href="{{ route('login') }}">Iniciar Sesión</flux:link>
                </flux:subheading>
            </div>
        </div>
    </div>
</x-layouts.auth>