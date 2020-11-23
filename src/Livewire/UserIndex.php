<?php

namespace Trov\Livewire;

use App\Models\User;
use Livewire\Component;

class UserIndex extends Component
{
    public function render()
    {
        return view('trov::users.index', [
            'users' => User::orderBy('name')->get(),
        ])
            ->extends('trov::layouts.base', [
                'title' => 'Manage Users'
            ])
            ->section('main');
    }
}
