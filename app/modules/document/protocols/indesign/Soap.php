<?php

namespace App\Modules\Document\Protocols\Indesign;

use App\Modules\Document\Protocols\ProtocolAbstract;
use App\Modules\Document\Models\Renderer;
use App\Modules\Document\Models\Connector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class Soap extends ProtocolAbstract
{
  private $_client = null;
  private $script_path = null;

  public function __construct()
  {
    $connector = Connector::where('name', '=', 'indesign_soap')->first();
    $renderer = Renderer::where('connector_id', '=', $connector->id)->first();
    parent::__construct($renderer);
  }

  public function connect()
  {
    Log::info("Attempting to connect to InDesign through SOAP");
    ini_set('soap.wsdl_cache_ttl', 0);
    ini_set("soap.wsdl_cache_enabled", 0);

    $url = '/data/app/config/opendtp/renderers/indesign/INDS.wsdl';
    $this->_client = new \SoapClient($url);

    Log::info("SOAP InDesign connection established");
  }

  #
  # Call an InDesign script through SOAP.
  # Name: the script name (with a jsx extension)
  # Params: An array of keys/values corresponding to the parameters the script need.
  #
  public function request($name, $params)
  {
    $script_parameters = array();

    # InDesign SOAP needs the parameters to be at the following format: array(array("name" => "param1_name", "value" => "param1_value")).
    foreach ($params as $key => $value)
      $script_parameters[] = array("name" => $key, "value" => $value);

    $client_response = null;
    try {
      $client_response = $this->_client->RunScript(array('runScriptParameters' => array(
        'scriptFile' => Config::get('opendtp/renderers/indesign/config.scripts_path').$name,
        'scriptArgs' => $script_parameters,
        'scriptLanguage' => 'javascript'
      )));
    } catch(\SoapFault $e) {
      Log::error($this->_client->__getLastResponse());
      Log::error($e->getMessage());
      return false;
    }
    $client_response = $this->obj2array($client_response);
    Log::info($client_response);
    return $client_response;
  }

  public function disconnect()
  {

  }

  private function obj2array($obj)
  {
    $out = array();
    foreach ($obj as $key => $val) {
      switch(true) {
          case is_object($val):
           $out[$key] = $this->obj2array($val);
           break;
        case is_array($val):
           $out[$key] = $this->obj2array($val);
           break;
        default:
          $out[$key] = $val;
      }
    }
    return $out;
  }
}

?>
