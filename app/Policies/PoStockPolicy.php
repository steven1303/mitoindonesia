<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoStockPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-view'){
                return true;
            }
        }
        return false;
    }

    public function store(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-store'){
                return true;
            }
        }
        return false;
    }

    public function update(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-update'){
                return true;
            }
        }
        return false;
    }

    public function delete(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-delete'){
                return true;
            }
        }
        return false;
    }

    public function open(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-open'){
                return true;
            }
        }
        return false;
    }

    public function verify(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-verify'){
                return true;
            }
        }
        return false;
    }

    public function approve(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-approve'){
                return true;
            }
        }
        return false;
    }
    public function print(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-stock-print'){
                return true;
            }
        }
        return false;
    }
}
