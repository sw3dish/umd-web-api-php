<?php
use \UMDWebAPI;

class MapTest extends PHPUnit_Framework_TestCase
{
	private function setupMock($fixture = 200)
    {
        if (is_int($fixture)) {
            $return = array(
                'status' => $fixture
            );
        } else {
            $fixture = __DIR__ . '/fixtures/map/' . $fixture . '.json';
            $fixture = file_get_contents($fixture);

            $response = json_decode($fixture);
            $return = array(
                'body' => $response
            );
        }
        $request = $this->getMock('UMDWebAPI\Request');
        $request->method('api')
                ->willReturn($return);
        $api = new UMDWebAPI\Map($request);
        return $api;
    }

    public function testGetBuildingsSingle()
    {
    	$api = $this->setupMock('buildings-single');
    	$response = $api->getBuildings('259');

    	$this->assertObjectHasAttribute('building_id', $response);
    }

    public function testGetBuildingsMultiple()
    {
    	$api = $this->setupMock('buildings-multiple');
    	$response = $api->getBuildings('259,D101');

    	$this->assertObjectHasAttribute('building_id', $response[0]);
    	$this->assertObjectHasAttribute('building_id', $response[0]);
    }

    public function testGetAllBuildings()
    {
    	$api = $this->setupMock('all-buildings');
    	$response = $api->getAllBuildings();

    	$this->assertObjectHasAttribute('building_id', $response[0]);
    }
}
