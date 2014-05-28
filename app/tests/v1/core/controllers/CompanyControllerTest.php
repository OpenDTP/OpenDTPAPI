<?php

namespace App\Tests\V1\Core\Controllers;

use App\Tests\V1\TestCase;

class CompanyControllerTest extends TestCase
{

    public function testControllerExists()
    {
        $response = $this->call('GET', $this->baseUrl . '/company');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
    }

    public function testShowCompanyValid()
    {
        $response = $this->call('GET', $this->baseUrl . '/company/1');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals('dcompany1', $dataResponse->data->name);
    }

    public function testCreateCompanyValid()
    {
        $company = [
            'name' => 'tcompany',
            'description' => 'test company'
        ];
        $response = $this->call('POST', $this->baseUrl . '/company', $company);
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals('Successfully created company ' . $dataResponse->data->id . ' !',
            $dataResponse->messages[0]);
        $this->assertEquals('tcompany', $dataResponse->data->name);
    }
}
