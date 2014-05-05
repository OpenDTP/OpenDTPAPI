<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initOpenDTP()
    {
        $openDTPIniFile = new Zend_Config_Ini(APPLICATION_PATH . '/configs/opendtp.ini', APPLICATION_ENV);
        Zend_Registry::set('OpenDTP', $openDTPIniFile);

        // Registering renderer connection manager
        $manager = new ODTPFramwork_Renderer_Manager((string)$openDTPIniFile->renderers->loader->default_config_path);
        Zend_Registry::set('RendererManager', $manager);
    }

    protected function _initAutoLoader()
    {
        Zend_Loader_Autoloader::getInstance();
    }

    protected function _initRestRoute()
    {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->registerPlugin(new Zend_Controller_Plugin_PutHandler());
        $frontController->registerPlugin(new ODTPFramwork_Controller_Plugin_DeleteHandler());
        $restRoute = new Zend_Rest_Route($frontController);
        $frontController->getRouter()->addRoute('default', $restRoute);
    }
}

