<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 30/05/14
 * Time: 12:19
 */

namespace App\Tests\V1\document\controllers;

use App\Tests\V1\Document\TestCase;

class ConnectorControllerTest extends TestCase
{

    public function testControllerExists()
    {
        $response = $this->call('GET', $this->baseUrl . '/connector');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
    }

    public function testShowValid()
    {
        $response = $this->call('GET', $this->baseUrl . '/user/1');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals('indesign_soap', $dataResponse->data->name);
        $this->assertEquals(1, $dataResponse->data->id);
    }
}
