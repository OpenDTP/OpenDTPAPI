<?php

namespace App\Modules\Storage\Models;

class Store extends \Eloquent
{
    protected $table = 'stores';

    public static function findByType($mime, $extension, $active = null)
    {
        $storeQuery = self::where('mime', '=', $mime)
            ->where('extension', '=', $extension);

        if (!is_null($active) && is_bool($active)) {
            $storeQuery->where('extension', '=', $active);
        }
        return $storeQuery->get();
    }
}
