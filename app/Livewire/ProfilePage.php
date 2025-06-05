<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProfilePage extends Component
{
    public User $user;
    public UserProfile $profile;
    public ?string $redirectTo = null;

    public bool $isEditing = false;

    #[Validate('required | string | max:255 ')]
    public string $first_name = '';

    #[Validate('required | string | max:255 ')]
    public string $last_name = '';

    #[Validate('required | string | max:255 ')]
    public string $phone = '';

    #[Validate('required | string | max:255 ')]
    public string $license_number = '';

    #[Validate('required | date')]
    public ?string $date_of_birth = null;

    public function mount(): void
    {
        $this->user = Auth::user();
        
        // Initialize with empty strings first
        $this->first_name = '';
        $this->last_name = '';
        $this->phone = '';
        $this->license_number = '';
        $this->date_of_birth = null;
        
        // Create or retrieve profile
        $this->profile = UserProfile::firstOrCreate(
            ['user_id' => $this->user->id],
            [
                'first_name' => '',
                'last_name' => '',
                'phone' => '',
                'license_number' => '',
                'date_of_birth' => null,
                'is_completed' => false
            ]
        );

        // Now safely assign values from profile
        $this->first_name = $this->profile->first_name;
        $this->last_name = $this->profile->last_name;
        $this->phone = $this->profile->phone;
        $this->license_number = $this->profile->license_number;
        $this->date_of_birth = $this->profile->date_of_birth;

        // Get redirect URL from session if exists
        $this->redirectTo = session('redirect_to');
        Log::info('Redirect URL in mount:', ['url' => $this->redirectTo]);

        // Automatically enable editing if profile is not completed
        if (!$this->profile->is_completed) {
            $this->isEditing = true;
        }
    }

    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
    }

    public function saveProfile()
    {
        $this->validate();

        $this->profile->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'license_number' => $this->license_number,
            'date_of_birth' => $this->date_of_birth,
            'is_completed' => true,
        ]);

        $this->isEditing = false;
        $this->dispatch('show-toast', 'Profile updated successfully', 'success');

        // If we have a redirect URL, navigate to it
        if ($this->redirectTo) {
            Log::info('Attempting to redirect:', ['url' => $this->redirectTo]);
            
            // Clear the session before redirecting
            $redirectUrl = $this->redirectTo;
            session()->forget('redirect_to');
            
            // Try direct navigation first
            return redirect()->to($redirectUrl);
        }
    }

    public function render()
    {
        return view('livewire.profile-page');
    }
}

