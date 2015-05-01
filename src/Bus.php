<?php
namespace UMDWebAPI;

class Bus extends Method
{
	private $request = null;

	/**
	 * Constructor
	 * Sets up Request object
	 *
	 * @param Request $request: Optional. The Request object to use
	 * 
	 * @return void
	 */
	public function __construct($request = null)
	{
		parent::__construct($request);
	}


	public function getRoutes($routeIds = "")
	{
		$routeIds = implode(',', (array) $routeIds);
		$routeIds = urlencode($routeIds);
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/map/routes/' . $routeIds, array(), $headers);
		return $response["body"];
	}

	public function getStops($stopName = "")
	{
		$stopName = strtolower($stopName);
		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0')
		return $response["body"];
	}
}