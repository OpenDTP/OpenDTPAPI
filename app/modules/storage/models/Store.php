<?php

namespace App\Modules\Storage\Models;

class Store extends \Eloquent
{
    protected $table = 'stores';

    public function getSettings()
    {
        return json_decode($this->settings, true);
    }

    public function setSettings($settings)
    {
        $this->settings = json_encode($settings);
    }
}
