<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 11/05/14
 * Time: 22:26
 */

namespace App\Modules\Core\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {
    protected $table = 'users';
    protected $hidden = array('password');

    public function companies() {
        return $this->belongsToMany('App\Modules\Core\Models\Company', 'users_companies', 'user_id', 'company_id');
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getReminderEmail()
    {
        return $this->email;
    }
}