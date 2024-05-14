<?php

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testApiResponse()
    {
        $data = ['foo' => 'bar'];
        $message = 'Success';
        $status = 200;

        $response = (new Controller())->apiResponse($data, $message, $status);

        $this->assertEquals($response->getStatusCode(), $status);
        $this->assertEquals($response->getData(true), [
            'data' => $data,
            'message' => $message
        ]);
    }
}
