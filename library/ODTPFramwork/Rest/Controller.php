<?php

class ODTPFramwork_Rest_Controller extends Zend_Rest_Controller
{

    public function init()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $request = $frontController->getRequest();
        $modulePath = $frontController->getModuleDirectory($request->getModuleName());

        if (file_exists($modulePath . '/configurations/' . $request->getControllerName() . '.ini')) {

            $config = new Zend_Config_Ini($modulePath . '/configurations/' . $request->getControllerName() . '.ini',
                APPLICATION_ENV);
            $actionName = $request->getActionName();

            if (!empty($config->$actionName)) {
                $this->form = new Zend_Form($config->$actionName);
            } else {
                $this->form = false;
            }

        } else {
            $this->form = false;
        }

        $this->view->error_code = 0;
        $this->view->error_type = '';
        $this->view->error_message = "Success !";

        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('index', array('json'))
            ->addActionContext('get', array("json"))
            ->addActionContext('post', array("json"))
            ->addActionContext('put', array("json"))
            ->addActionContext('delete', array("json"))
            ->initContext('json');
    }

    protected function setException($e)
    {
        $this->view->error_code = $e->getCode();
        $this->view->error_type = get_class($e);
        $this->view->error_message = $e->getMessage();
    }

    public function indexAction()
    {
    }

    public function headAction()
    {
    }

    public function getAction()
    {
    }

    public function postAction()
    {
    }

    public function putAction()
    {
    }

    public function deleteAction()
    {
    }

}
