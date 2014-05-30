<?php

namespace App\Tests\V1\Core\Controllers;

use App\Tests\V1\TestCase;

class CompanyUserControllerTest extends TestCase
{

    public function testControllerExists()
    {
        $response = $this->call('GET', $this->baseUrl . '/company/user');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
    }

    public function testUsersCompanyListValid()
    {
        $response = $this->call('GET', $this->baseUrl . '/company/user/1');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertCount(3, $dataResponse->data);
        $this->assertEquals('admin', $dataResponse->data[0]->login);
        $this->assertEquals('duser1', $dataResponse->data[1]->login);
        $this->assertEquals('duser2', $dataResponse->data[2]->login);
    }
}
