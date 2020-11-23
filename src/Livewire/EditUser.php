<?php

namespace Trov\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public $user;
    public $permissions = [];
    public $roles = [];
    public $newPassword;
    public $allPermissions;
    public $allRoles;
    public $showResetPasswordModal = false;

    public $name;
    public $email;
    public $facebook;
    public $twitter;
    public $instagram;
    public $linkedin;
    public $youtube;
    public $website;
    public $bio;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->facebook = $user->facebook;
        $this->twitter = $user->twitter;
        $this->instagram = $user->instagram;
        $this->linkedin = $user->linkedin;
        $this->youtube = $user->youtube;
        $this->website = $user->website;
        $this->bio = $user->bio;
        $this->permissions = $user->getAllPermissions()->pluck('name');
        $this->roles = $user->getRoleNames();
        $this->allPermissions = Permission::orderBy('name')->pluck('name')->all();
        $this->allRoles = Role::orderBy('name')->pluck('name')->all();
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
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $this->user->id,
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
            'website' => 'nullable|url',
            'bio' => 'nullable',
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'website' => $this->website,
            'bio' => $this->bio,
        ]);

        $this->user->syncRoles($this->roles);
        $this->user->syncPermissions($this->permissions);

        $this->notify(['type' => 'success', 'message' => 'User Updated!']);
    }

    public function render()
    {
        return view('trov::users.edit')
            ->extends('trov::layouts.base', [
                'title' => 'Edit User',
            ])
            ->section('main');
    }
}
