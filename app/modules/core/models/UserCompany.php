<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 13/05/14
 * Time: 11:26
 */

namespace App\Modules\Core\Models;

class UserCompany extends \Eloquent {
    protected $table = 'users_companies';

    public static function findRelation($company_id, $user_id) {
        return UserCompany::where('company_id', '=', $company_id)
            ->where('user_id', '=', $user_id)
            ->first();
    }

    public function delete() {
        return UserCompany::where('company_id', '=', $this->company_id)
            ->where('user_id', '=', $this->user_id)
            ->delete();
    }
} 