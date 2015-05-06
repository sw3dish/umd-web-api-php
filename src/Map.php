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
	 *
	 * Buildings endpoint
	 * http://api.umd.io/v0/map/buildings
	 *
	 */
	/**
     * Get location data about one or more buildings
     * http://api.umd.io/v0/map/buildings/<building_number>
     * for more information see http://umd.io/map/#get_buildings
     *
     * @param string|array $buildingIds :
     * - string $buildingIds : single building number
     * - array $buildingIds : an array of building numbers
     *
     * @return array|object : The response body. Contains one or more Building objects.
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/map/#building_object
	 */
	public function getBuildings($buildingIds) 
	{
		$buildingIds = urlencode(implode(',', (array) $buildingIds));

		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/map/buildings/' . $buildingIds, array(), $headers);

		return $response["body"];
	}
	/**
     * Get location data about all buildings
     * http://api.umd.io/v0/map/buildings
     * for more information, see http://umd.io/map/#list_buildings
     *
     * @return array|object : The response body. Contains one or more Building objects.
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/map/#building_object
	 */
	public function getAllBuildings()
	{
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/map/buildings/', array(), $headers);

		return $response["body"];
	}
}
