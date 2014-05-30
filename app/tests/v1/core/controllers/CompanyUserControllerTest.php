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

    public function testUsersCompanyLinkValid()
    {
        $link = [
            'user_id' => 4,
            'company_id' => 1
        ];
        $response = $this->call('POST', $this->baseUrl . '/company/user', $link);
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals(1, $dataResponse->data->company_id);
        $this->assertEquals(4, $dataResponse->data->user_id);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertEquals($dataResponse->messages[0], 'Successfully associated user 4 to company 1 !');
    }

    public function testUsersCompanyUnlinkValid()
    {
        $response = $this->call('DELETE', $this->baseUrl . '/company/user/2/4');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals(2, $dataResponse->data->company_id);
        $this->assertEquals(4, $dataResponse->data->user_id);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertEquals($dataResponse->messages[0], 'Successfully unassociated user 4 to company 2 !');
    }
}
