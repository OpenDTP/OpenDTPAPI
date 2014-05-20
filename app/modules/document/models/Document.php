<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 14/05/14
 * Time: 00:48
 */

namespace App\Modules\Document\Models;


class Document extends \Eloquent
{
    protected $table = 'documents';

    public function type()
    {
        return $this->hasOne('documents_types', 'id');
    }
}
