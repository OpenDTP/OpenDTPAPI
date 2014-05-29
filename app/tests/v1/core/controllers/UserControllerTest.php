<?php

namespace App\Tests\V1\Core\Controllers;

use App\Tests\V1\TestCase;

class UserControllerTest extends TestCase
{

    public function testControllerExists()
    {
        $response = $this->call('GET', $this->baseUrl . '/user');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
    }

    public function testIsLoggedOn()
    {
        $response = $this->call('GET', $this->baseUrl . '/user');
        $dataResponse = $this->parseJson($response);

        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals($dataResponse->data->id, 1);
        $this->assertEquals($dataResponse->data->login, 'admin');
        $this->assertEquals($dataResponse->data->email, 'fake_email@provider.com');
        $this->assertEquals($dataResponse->data->valid, 1);
        $this->assertEquals($dataResponse->data->blocked, 0);
    }

    public function testCreateValid()
    {
        $user = [
            'login' => 'tuser',
            'password' => 'tuserpwd',
            'email' => 'tuser@fake.opendtp.net'
        ];
        $response = $this->call('POST', $this->baseUrl . '/user', $user);
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals('Successfully created user ' . $dataResponse->data->id . ' !', $dataResponse->messages[0]);
    }

    public function testUpdateValid()
    {
        $user = [
            'email' => 'update@fake.opendtp.net'
        ];
        $response = $this->call('PUT', $this->baseUrl . '/user/2', $user);
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertNotEmpty($dataResponse->data);
        $this->assertEquals('Successfully updated user 2 !', $dataResponse->messages[0]);
        $this->assertEquals($dataResponse->data->email, 'update@fake.opendtp.net');
    }

    public function testDeleteValid()
    {
        $response = $this->call('DELETE', $this->baseUrl . '/user/6');
        $dataResponse = $this->parseJson($response);

        $this->assertIsJson($dataResponse);
        $this->assertEquals(API_RETURN_200, $dataResponse->code);
        $this->assertNotEmpty($dataResponse->messages);
        $this->assertEquals('User 6 deleted', $dataResponse->messages[0]);
    }
}
