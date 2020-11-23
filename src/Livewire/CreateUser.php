<?php

namespace Trov\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    public $permissions = [];
    public $roles = [];
    public $allPermissions;
    public $allRoles;

    public $name;
    public $email;
    public $password;
    public $facebook;
    public $twitter;
    public $instagram;
    public $linkedin;
    public $youtube;
    public $website;
    public $bio;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users, email',
        'password' => 'required|min:8',
        'permissions.*' => 'sometimes',
        'roles' => 'required',
        'facebook' => 'nullable|url',
        'twitter' => 'nullable|url',
        'instagram' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'youtube' => 'nullable|url',
        'website' => 'nullable|url',
        'bio' => 'nullable',
    ];

    public function mount()
    {
        $this->allPermissions = Permission::orderBy('name')->pluck('name')->all();
        $this->allRoles = Role::orderBy('name')->pluck('name')->all();
    }

    public function generatePassword()
    {
        $this->password = Str::random(32);
    }

    public function submit()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'website' => $this->website,
            'bio' => $this->bio,
        ]);

        $user->syncRoles($this->roles);
        $user->syncPermissions($this->permissions);

        session()->flash('notification', ['type' => 'success', 'message' => 'User Created!']);
        $this->redirect(route('cms.users.edit', $user));
    }

    public function render()
    {
        return view('trov::users.create')
            ->extends('trov::layouts.base', [
                'title' => 'New User',
            ])
            ->section('main');
    }
}
