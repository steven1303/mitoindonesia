<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    use Notifiable;

	protected $guard = 'admin';

	protected $fillable = [
        'name', 'username' ,'email', 'password','id_role','id_branch',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function roles()
    {
        return $this->hasOne('App\Models\Role','id','id_role');
    }
}
