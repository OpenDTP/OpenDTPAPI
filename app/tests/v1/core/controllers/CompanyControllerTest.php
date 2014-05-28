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

    public function testUserCompanies()
    {
        $response = $this->call('GET', $this->baseUrl . '/company');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertCount(2, $dataResponse->data);
        $this->assertEquals($dataResponse->data[0]->name, 'dcompany1');
        $this->assertEquals($dataResponse->data[1]->name, 'dcompany2');
    }

    public function testShowCompanyValid()
    {
        $response = $this->call('GET', $this->baseUrl . '/company/1');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
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
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals('Successfully created company ' . $dataResponse->data->id . ' !',
            $dataResponse->messages[0]);
        $this->assertEquals('tcompany', $dataResponse->data->name);
    }

    public function testUpdateCompanyValid()
    {
        $company = [
            'name' => 'tcompany2',
        ];
        $response = $this->call('PUT', $this->baseUrl . '/company/1', $company);
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals('Successfully updated company 1 !',
            $dataResponse->messages[0]);
        $this->assertEquals('tcompany2', $dataResponse->data->name);
    }

    public function testDeleteCompanyValid()
    {
        $response = $this->call('DELETE', $this->baseUrl . '/company/3');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertEquals('Company 3 deleted',
            $dataResponse->messages[0]);
    }
}
