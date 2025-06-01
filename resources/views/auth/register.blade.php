<x-layouts.auth title="Sign Up">
    <div class="flex min-h-screen">
        <div class="flex-1 flex justify-center items-center">
            <div class="w-80 max-w-80 space-y-6">
                <div class="flex justify-center opacity-50">
                    <a href="/" class="group flex items-center gap-3">
                        <flux:icon.car-front class="size-8 text-black dark:text-white" />
                        <span class="text-xl font-semibold text-zinc-800 dark:text-white">Rent a car</span>
                    </a>
                </div>

                <flux:heading class="text-center" size="xl">Register New Account</flux:heading>

                <flux:separator />

                <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-6">
                    @csrf

                    <flux:input name="email" label="Email" type="email" placeholder="email@example.com" value="{{ old('email') }}" />

                    <flux:field>
                        <div class="mb-3 flex justify-between">
                            <flux:label>Password</flux:label>
                        </div>
                        <flux:input name="password" type="password" placeholder="Your password" />
                    </flux:field>

                    <flux:button type="submit" variant="primary" class="w-full">Sign Up</flux:button>
                </form>
    
                <flux:subheading class="text-center">
                    Already have an account? <flux:link href="{{ route('login') }}">Sign in</flux:link>
                </flux:subheading>
            </div>
        </div>
    </div>
</x-layouts.auth>