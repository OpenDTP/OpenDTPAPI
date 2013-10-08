<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initOpenDTP() {
    $openDTPIniFile = new Zend_Config_Ini(APPLICATION_PATH . '/configs/opendtp.ini', APPLICATION_ENV);
    Zend_Registry::set('OpenDTP', $openDTPIniFile);

    // registering plugin loader
    $parameters = array(
      'preload' => (bool)$openDTPIniFile->renderers->loader->preload,
      'default_config_path' => (string)$openDTPIniFile->renderers->loader->default_config_path
    );
    $loader = new ODTPFramwork_Renderer_Loader($parameters);
    Zend_Registry::set('RendererLoader', $loader);
  }

	protected function _initAutoLoader() {
    $autoloader = Zend_Loader_Autoloader::getInstance();
	}

	protected function _initRestRoute() {
    $this->bootstrap('frontController');
    $frontController = Zend_Controller_Front::getInstance();
    $frontController->registerPlugin(new Zend_Controller_Plugin_PutHandler());
    $frontController->registerPlugin(new ODTPFramwork_Controller_Plugin_DeleteHandler());
    $restRoute = new Zend_Rest_Route($frontController);
    $frontController->getRouter()->addRoute('default', $restRoute);
  }
}

