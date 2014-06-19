<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 19/06/14
 * Time: 13:52
 */

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public function register()
    {
        Log::info('Appel du validation provider');
    }
}
