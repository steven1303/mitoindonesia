<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
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
            if($permission->name == 'invoice-view'){
                return true;
            }
        }
        return false;
    }

    public function store(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-store'){
                return true;
            }
        }
        return false;
    }

    public function update(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-update'){
                return true;
            }
        }
        return false;
    }

    public function delete(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-delete'){
                return true;
            }
        }
        return false;
    }

    public function open(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-open'){
                return true;
            }
        }
        return false;
    }

    public function verify1(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-verify1'){
                return true;
            }
        }
        return false;
    }

    public function verify2(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-verify2'){
                return true;
            }
        }
        return false;
    }

    public function approve(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-approve'){
                return true;
            }
        }
        return false;
    }
    public function print(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-print'){
                return true;
            }
        }
        return false;
    }
    public function pembatalan(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'invoice-reject'){
                return true;
            }
        }
        return false;
    }
}
