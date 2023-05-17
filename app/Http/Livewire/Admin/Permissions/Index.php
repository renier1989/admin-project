<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    public function render()
    {

        $permissions = Permission::all();

        return view('livewire.admin.permissions.index',compact('permissions'))
        ->extends('layouts.admin')
        ->section('content');
    }
}
