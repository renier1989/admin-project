<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{

    public function render()
    {
        $roles = Role::all();
        return view('livewire.admin.roles.index' , compact('roles'))
        ->extends('layouts.admin')
        ->section('content');
    }
}
