<?php
require_once 'Zend/Application.php';


abstract class LibraryTestCase extends PHPUnit_Framework_TestCase
{
    public $application;

    public function setUp()
    {
        $this->application = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );

        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }

    public function appBootstrap()
    {
        $this->application->bootstrap();
	}
}