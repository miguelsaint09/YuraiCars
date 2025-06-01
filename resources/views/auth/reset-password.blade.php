<x-layouts.auth title="Reset Password">
    <div class="flex min-h-screen">
        <div class="flex-1 flex justify-center items-center">
            <livewire:auth.reset-password 
                :token="request()->route('token')" 
                :email="request()->query('email')" 
            />
        </div>
    </div>
</x-layouts.auth>
