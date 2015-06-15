<?php
use \UMDWebAPI;

class RequestTest extends PHPUnit_Framework_TestCase
{
	private $request = null;

	public function setUp()
	{
		$this->request = new UMDWebAPI\Request();
	}

	public function testApi()
	{
		$response = $this->request->api('GET', '/v0/map/buildings/251');
		
		$this->assertObjectHasAttribute("building_id", $response["body"]);
	}

	public function testApiParameters()
	{
		$response = $this->request->api('GET', '/v0/map/buildings/251,345');

		$this->assertObjectHasAttribute("building_id", $response["body"][0]);
		$this->assertObjectHasAttribute("building_id", $response["body"][1]);
	}

	public function testSend()
	{
		$response = $this->request->send('GET', 'http://api.umd.io/v0/map/buildings/251');

		$this->assertObjectHasAttribute("building_id", $response["body"]);
	}

	public function testSendParameters()
	{
		$response = $this->request->send('GET', 'http://api.umd.io/v0/map/buildings/251,345');

		$this->assertObjectHasAttribute("building_id", $response["body"][0]);
		$this->assertObjectHasAttribute("building_id", $response["body"][1]);

	}

	public function testSendStatus()
	{
		$response = $this->request->send('GET', 'http://api.umd.io/v0/map/buildings/251');

		$this->assertEquals(200, $response['status']);
	}

	public function testSendMalformed()
	{
		$this->setExpectedException('UMDWebAPI\UMDWebAPIException');

		$response = $this->request->send('GET', 'http://api.umd.io/v0/map/buildings/NON_EXISTANT_BUILDING');
	}

	public function testSetReturnAssoc()
    {
        $request = new UMDWebAPI\Request();
        $this->assertFalse($request->getReturnAssoc());

        $request->setReturnAssoc(true);
        $this->assertTrue($request->getReturnAssoc());

        $request->setReturnAssoc(false);
        $this->assertFalse($request->getReturnAssoc());
    }
    public function testSendReturnAssoc()
    {
        $request = new UMDWebAPI\Request();
        $request->setReturnAssoc(true);

        $response = $request->send('GET', 'http://api.umd.io/v0/map/buildings/251');
        $this->assertArrayHasKey('building_id', $response['body']);
    }
}
