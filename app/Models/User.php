<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
      use HasApiTokens, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    /**
     * Get the roles associated with the user.
     */

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role')->using(UserRole::class);
    }


    /**
     * Get the permissions directly assigned to the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    /**
     * Check if the user has a specific permission.
     */
    public function hasPermission($permission)
    {
        return $this->permissions->contains('name', $permission) ||
               $this->roles->pluck('permissions')->flatten()->contains('name', $permission);
    }
}
