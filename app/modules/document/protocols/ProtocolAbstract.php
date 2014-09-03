<?php

namespace App\Modules\Document\Protocols;

use App\Modules\Document\Models\Renderer;
use Illuminate\Support\Facades\Log;

abstract class ProtocolAbstract implements IProtocol
{
  protected $_renderer = null;

  public function __construct(Renderer $renderer)
  {
    $this->_renderer = $renderer;
  }
}

?>
