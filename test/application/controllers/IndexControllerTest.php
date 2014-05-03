<?php
class IndexControllerTest extends ControllerTestCase
{
    public function testErrorURL()
	{
        $this->dispatch('foo');
        $this->assertController('error');
        $this->assertAction('error');
    }
}