<?php

namespace App\Livewire\Ui;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public ?string $message = null;
    public string $severity = 'info';
    public bool $visible = false;

    #[On('show-toast')] 
    public function showToast(string $message, string $severity = 'info')
    {
        $this->message = $message;
        $this->severity = $severity;
        $this->visible = true;
    }

    #[On('hide-toast')] 
    public function hideToast()
    {
        $this->visible = false;
    }

    public function render()
    {
        return view('livewire.ui.toast');
    }
}
