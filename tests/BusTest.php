<?php
use \UMDWebAPI;

class BusTest extends PHPUnit_Framework_TestCase
{
	private function setupMock($fixture = 200)
    {
        if (is_int($fixture)) {
            $return = array(
                'status' => $fixture
            );
        } else {
            $fixture = __DIR__ . '/fixtures/bus/' . $fixture . '.json';
            $fixture = file_get_contents($fixture);
            $response = json_decode($fixture);
            $return = array(
                'body' => $response
            );
        }
        $request = $this->getMock('UMDWebAPI\Request');
        $request->method('api')
                ->willReturn($return);
        $api = new UMDWebAPI\Bus($request);
        return $api;
    }

    public function testGetRoutesSingle()
    {
    	$api = $this->setupMock('routes-single');
    	$response = $api->getRoutes('109');

    	$this->assertTrue($response);
    }
}
