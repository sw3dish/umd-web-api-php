<?php
namespace UMDWebAPI;

class Map extends Method
{

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
	/**
     * Get location data about one or more buildings
     * http://api.umd.io/v0/map/buildings
     *
     * @param string|array buildingNumbers : Optional. Omitting will return all buildings
     * - string buildingNumbers : single building number
     * - array buildingNumbers : an array of building numbers
     *
     *
     * @return bool Whether the tracks was successfully added.
	 */
	public function getBuildings($buildingNumbers = "") 
	{
		$buildingNumbers = implode(',', (array) $buildingNumbers);
		$buildingNumbers = urlencode($buildingNumbers);
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/map/buildings/' . $buildingNumbers, array(), $headers);

		return $response["body"];
	}
}