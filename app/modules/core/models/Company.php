<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 11/05/14
 * Time: 22:31
 */

namespace App\Modules\Core\Models;


class Company extends \Eloquent
{
    protected $table = 'companies';

    public function users()
    {
        return $this->belongsToMany(
            'App\Modules\Core\Models\User',
            'users_companies',
            'company_id',
            'user_id'
        );
    }
}
