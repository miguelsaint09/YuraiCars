<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ForgotPassword extends Component
{
    #[Validate('required | email')]
    public string $email = '';

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->reset('email');
            $this->dispatch('show-toast', 'A password reset link has been sent to your email', 'success');
        } else {
            $this->addError('email', __('Something went wrong'));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
