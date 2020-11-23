<?php

namespace Trov\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Profile extends Component
{
    use AuthorizesRequests;

    public $user;
    public $profile;
    public $newPassword;
    public $showResetPasswordModal = false;

    protected $rules = [
        'user.name' => 'required',
        'user.facebook' => 'sometimes|url',
        'user.twitter' => 'sometimes|url',
        'user.instagram' => 'sometimes|url',
        'user.linkedin' => 'sometimes|url',
        'user.youtube' => 'sometimes|url',
        'user.website' => 'sometimes|url',
        'user.bio' => 'sometimes',
    ];

    protected $messages = [
        'user.facebook.url' => 'Invalid URL.',
        'user.twitter.url' => 'Invalid URL.',
        'user.instagram.url' => 'Invalid URL.',
        'user.linkedin.url' => 'Invalid URL.',
        'user.youtube.url' => 'Invalid URL.',
        'user.website.url' => 'Invalid URL.',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function generatePassword()
    {
        $this->newPassword = Str::random(32);
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required',
        ]);

        $this->user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        $this->showResetPasswordModal = false;
        $this->newPassword = '';
        $this->notify(['type' => 'success', 'message' => 'Password Updated!']);
    }

    public function openPasswordModal()
    {
        $this->showResetPasswordModal = true;
        $this->newPassword = '';
    }

    public function submit()
    {
        $this->authorize('manage-profile', $this->user);

        $this->validate();

        $this->user->save();

        $this->notify(['type' => 'success', 'message' => 'Profile Updated!']);
    }

    public function render()
    {
        $this->authorize('manage-profile', $this->user);

        return view('trov::profile')
            ->extends('trov::layouts.base', [
                'title' => 'Profile'
            ])
            ->section('main');
    }
}
