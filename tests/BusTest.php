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

    	$this->assertObjectHasAttribute('route_id', $response);
    }

    public function testGetRoutesMultiple()
    {
    	$api = $this->setupMock('routes-multiple');
    	$response = $api->getRoutes(array('109', '115'));

    	$this->assertObjectHasAttribute('route_id', $response['0']);
    	$this->assertObjectHasAttribute('route_id', $response['1']);
    }

    public function testGetAllRoutes()
    {
    	//$api = $this->setupMock('all-routes');
    	//$response = $api->getAllRoutes();

    	//$this->assertNotEmpty($response);
    }

    public function testGetRouteLocations()
    {
    	//$api = $this->setupMock('route-locations');
    }

    public function testGetStopArrivals()
    {
    	//$api = $this->setupMock('stop-arrivals');
    	//$response = $api->getStopArrivals('115', 'laplat');
    }

    public function testGetRouteSchedules()
    {
    	$api = $this->setupMock('route-schedules');
    	$response = $api->getRouteSchedules('115');

    	$this->assertObjectHasAttribute('stops', $response[0]);
    }

    public function testGetStopsSingle()
    {
    	$api = $this->setupMock('stops-single');
    	$response = $api->getStops('laplat');

    	$this->assertObjectHasAttribute('stop_id', $response[0]);
    }

    public function testGetAllStops()
    {
    	$api = $this->setupMock('all-stops');
    	$response = $api->getStops('laplat');

    	$this->assertObjectHasAttribute('stop_id', $response[0]);
    }

    public function testGetAllLocations()
    {
    	/*$api = $this->setupMock('all-locations');
    	$response = $api->getLocations();

    	$this->assertObjectHasAttribute('id', $response[0]);*/
    }
}
