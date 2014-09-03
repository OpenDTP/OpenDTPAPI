<?php

namespace App\Modules\Document\Protocols;

interface IProtocol
{
  public function connect();
  public function request($name, $params);
  public function disconnect();
}

?>
