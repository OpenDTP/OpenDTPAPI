<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 11/05/14
 * Time: 22:26
 */

namespace App\Modules\Auth\Models;

class OAuthClients extends \Eloquent
{
    protected $table = 'oauth_clients';
    protected $hidden = array('secret');
}
