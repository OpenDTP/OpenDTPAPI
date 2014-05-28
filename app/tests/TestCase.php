<?php

namespace App\Tests;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    public function setUp()
    {
        parent::setUp();

        Route::enableFilters();
        Auth::loginUsingId(1);
    }

    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';
        return require __DIR__ . '/../../bootstrap/start.php';
    }

    protected function parseJson(JsonResponse $response)
    {
        return json_decode($response->getContent());
    }

    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error());
    }
}
