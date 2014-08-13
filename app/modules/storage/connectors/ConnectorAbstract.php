<?php

namespace App\Modules\Storage\Connectors;

use App\Modules\Storage\Models\Store;

abstract class ConnectorAbstract implements IConnector
{
    protected $settings = null;

    public function __construct(Store $store)
    {
        $this->init($store);
    }

    public function init(Store $store)
    {
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

}
