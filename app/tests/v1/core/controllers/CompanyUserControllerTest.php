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
        $this->assertNotEmpty($dataResponse->data);
    }
}
