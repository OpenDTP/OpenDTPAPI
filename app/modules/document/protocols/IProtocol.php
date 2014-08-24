<?php

namespace App\Modules\Document\Protocols;

interface IProtocol
{
  public function connect();
  public function request();
  public function disconnect();
}

?>
