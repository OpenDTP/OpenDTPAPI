<?php
/*
*	@group Library
*	@group Query
*/


class QueryTest extends ControllerTestCase
{

	public function testStringQuery() 
	{
		$loader = Zend_Registry::get('RendererLoader');
        $query = new ODTPFramwork_Renderer_Query('RENDER test.sla, test2.sla OUTPUT test.pdf, test2.pdf');
		echo $query;
		$this->assertEquals("Test", $query);
    }
}