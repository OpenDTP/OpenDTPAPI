<?php

namespace App\Modules\Document\Protocols\Indesign;

use App\Modules\Document\Protocols\ProtocolAbstract;
use App\Modules\Document\Models\Renderer;
use App\Modules\Document\Models\Connector;
use Illuminate\Support\Facades\Log;

class Soap extends ProtocolAbstract
{
  public function __construct()
  {
    $connector = Connector::where('name', '=', 'indesign_soap')->first();
    $renderer = Renderer::where('connector_id', '=', $connector->id)->first();
    parent::__construct($renderer);
  }

  public function connect()
  {

  }

  public function request()
  {

  }

  public function disconnect()
  {

  }
}

?>
