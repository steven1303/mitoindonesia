<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricelistPolicy
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
            if($permission->name == 'pricelist-view'){
                return true;
            }
        }
        return false;
    }

    public function update(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'pricelist-update'){
                return true;
            }
        }
        return false;
    }
}
