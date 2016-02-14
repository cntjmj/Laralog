<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'acl',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'acl',
    ];
    
    CONST ACL_ADMIN = 0x01;
    CONST ACL_SUPER_ADMIN = 0x02;
    
    public function is_admin() {
        if ($this->acl & self::ACL_ADMIN || $this->acl & self::ACL_SUPER_ADMIN)
            return true;
        else
        	return false;
    }
    
    public function is_superadmin() {
        if ($this->acl & self::ACL_SUPER_ADMIN)
            return true;
        else
    	    return false;
    }
    
    public function title() {
        if ($this->is_superadmin())
            return 'Captain';
        else if ($this->is_admin())
            return 'Commander';
        else
            return 'Dear';
    }
}
