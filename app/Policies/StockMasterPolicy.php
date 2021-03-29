<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockMasterPolicy
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
            if($permission->name == 'stock-master-view'){
                return true;
            }
        }
        return false;
    }

    public function store(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'stock-master-store'){
                return true;
            }
        }
        return false;
    }

    public function update(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'stock-master-update'){
                return true;
            }
        }
        return false;
    }

    public function delete(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'stock-master-delete'){
                return true;
            }
        }
        return false;
    }

    public function movement(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'stock-master-movement'){
                return true;
            }
        }
        return false;
    }
}
