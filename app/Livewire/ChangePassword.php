<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ChangePassword extends Component
{
    #[Validate('required|current_password')]
    public string $current_password = '';

    #[Validate('required|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public bool $isChangingPassword = false;

    public function toggleChangePassword(): void
    {
        $this->isChangingPassword = !$this->isChangingPassword;
        $this->reset(['current_password', 'password', 'password_confirmation']);
    }

    public function changePassword(): void
    {
        $this->validate();

        auth()->user()->update([
            'password' => Hash::make($this->password)
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->isChangingPassword = false;
        $this->dispatch('show-toast', 'Password changed successfully', 'success');
    }

    public function render()
    {
        return view('livewire.change-password');
    }
} 