<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoInternalPolicy
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
            if($permission->name == 'po-internal-view'){
                return true;
            }
        }
        return false;
    }

    public function store(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-internal-store'){
                return true;
            }
        }
        return false;
    }

    public function update(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-internal-update'){
                return true;
            }
        }
        return false;
    }

    public function delete(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-internal-delete'){
                return true;
            }
        }
        return false;
    }

    public function open(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-internal-open'){
                return true;
            }
        }
        return false;
    }

    public function approve(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-internal-approve'){
                return true;
            }
        }
        return false;
    }
    public function print(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'po-internal-print'){
                return true;
            }
        }
        return false;
    }
}
