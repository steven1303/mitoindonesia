<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PembatalanPolicy
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
            if($permission->name == 'pembatalan-view'){
                return true;
            }
        }
        return false;
    }

    public function po_stock(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'pembatalan-po-stock'){
                return true;
            }
        }
        return false;
    }

    public function po_non_stock(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'pembatalan-po-non_stock'){
                return true;
            }
        }
        return false;
    }

    public function invoice(Admin $user)
    {
        foreach ($user->roles->Permissions as $permission ) {
            if($permission->name == 'pembatalan-invoice'){
                return true;
            }
        }
        return false;
    }
}
