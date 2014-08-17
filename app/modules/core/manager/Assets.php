<?php

namespace App\Modules\Core\Manager;

use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Assets
{
    private $store;

    public function __construct()
    {
        $this->store = Config::get('opendtp/assets.store');

        if (empty($this->store)) {
            throw new \Exception('Assets opendtp/assets.store is undefined', API_RETURN_500);
        }
    }

    public function put($ressource_type, UploadedFile $file)
    {
        $config = Config::get('opendtp/assets.' . $ressource_type);
        $adapter = new $config['adapter'];
        return $adapter->put($file, $this->store, $config);
    }

    public function get($ressource_type, $file_id)
    {
        $config = Config::get('opendtp/assets.' . $ressource_type);
        $adapter = new $config['adapter'];
        return $adapter->get($file_id, $this->store, $config);
    }

    public function destroy($ressource_type, $file_id)
    {
        $config = Config::get('opendtp/assets.' . $ressource_type);
        $adapter = new $config['adapter'];
        return $adapter->destroy($file_id, $this->store, $config);
    }
}
