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
	/*
	 *
	 * Routes Endpoint
	 * http://api.umd.io/v0/bus/routes/
	 *
	 */
	/**
     * Get data about one or more bus routes
     * http://api.umd.io/v0/bus/routes/<route_id>
     * for more information see http://umd.io/bus/#get_routes
     *
     * @param string|array $routeNumbers :
     * - string $routeNumbers : single bus route identifier
     * - array $routeNumbers : an array of bus route identifiers
     *
     * @return array|object : The response body. Contains one or more Route objects.
     * Type is controlled by Request::setReturnAssoc().
     * More information on Route object can be found at http://umd.io/bus/#route_object
	 */
	public function getRoutes($routeIds)
	{
		$routeIds = implode(',', (array) $routeIds);
		$routeIds = urlencode($routeIds);
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/bus/routes/' . $routeIds, array(), $headers);
		return $response["body"];
	}
	/**
     * Get data about all bus routes
     * http://api.umd.io/v0/bus/routes/
     * for more information see http://umd.io/bus/#list_routes
     *
     * @return array|object : The response body. Contains one or more objects with
     * route_id and title.
     * Type is controlled by Request::setReturnAssoc().
     * More information on Route object can be found at http://umd.io/bus/#route_object
	 */
	public function getAllRoutes()
	{
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/bus/routes/', array(), $headers);
		return $response["body"];
	}
	/**
     * Get data about one or more bus locations along a bus route
     * http://api.umd.io/v0/bus/routes/<route_id>/locations/
     * for more information see http://umd.io/bus/#route_locations
     *
     * @param string $routeId: single bus route identifier
     *
     * @return array|object : The response body. Bus locations for the route
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/bus/#route_locations
	 */
	public function getRouteLocations($routeId)
	{	
		$routeId = urlencode(strtolower($routeId));

		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/bus/routes/' . $routeId . 
									'/locations/', array(), $headers);
		return $response["body"];
	}
	/**
     * Get data about one or more predicted arrivals for a stop along a bus route
     * http://api.umd.io/v0/bus/routes/<route_id>/arrivals/<stop_id>
     * for more information see http://umd.io/bus/#arrivals
     *
     * @param string $routeId: single bus route identifier
     * @param string $stopId: single bus stop identifier
     *
     * @return array|object : The response body. Predicted arrivals for a stop on
     * the route
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/bus/#arrivals
	 */
	public function getStopArrivals($routeId, $stopId)
	{	
		$routeId = urlencode(strtolower($routeId));
		$stopId = urlencode(strtolower($stopId));

		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/bus/routes/' . $routeId . 
									'/arrivals/' . $stopId, array(), $headers);
		return $response["body"];
	}
	/**
     * Get schedule data for a bus route
     * http://api.umd.io/v0/bus/routes/<route_id>/schedules/
     * for more information see http://umd.io/bus/#route_schedules
     *
     * @param string $routeId: single bus route identifier
     *
     * @return array|object : The response body. Schedule data for the route
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/bus/#route_schedules
	 */
	public function getRouteLocations($routeId)
	{	
		$routeId = urlencode(strtolower($routeId));

		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/bus/routes/' . $routeId . 
									'/schedules/', array(), $headers);
		return $response["body"];
	}
	/*
	 *
	 * Stops Endpoint
	 * http://api.umd.io/v0/bus/stops/
	 *
	 */
	/**
     * Get data about a single bus stop
     * http://api.umd.io/v0/bus/stops/<stop_id>
     * for more intormation see http://umd.io/bus/#get_stops
     *
     * @param string $stopId: single bus stop identifier
     *
     * @return array|object : The response body. Contains Stop object.
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/bus/#stop_object
	 */
	public function getStops($stopId)
	{
		$stopId = urlencode(strtolower($stopId));

		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/bus/stops/' . $stopId, array(), $headers);
		return $response["body"];
	}
	/**
     * Get data about all bus stops
     * http://api.umd.io/v0/bus/stops/
     * for more information see http://umd.io/bus/#stops
     *
     * @param string $stopId: single bus route identifier
     *
     * @return array|object : The response body. Contains one or more objects with
     * stop_id and title.
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/bus/#stops
	 */
	public function getAllStops()
	{
		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/bus/stops/', array(), $headers);
		return $response["body"];
	}
	/*
	 *
	 * Locations Endpoint
	 * http://api.umd.io/v0/bus/locations/
	 *
	 */
	/**
     * Get data about one or more bus locations
     * http://api.umd.io/v0/bus/locations
     * for more information see http://umd.io/bus/#locations
     *
     * @return array|object : The response body. Contains meta information and list
     * of locations for vehicles
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/bus/#locations
	 */
	public function getAllLocations()
	{
		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/bus/locations/', array(), $headers);
		return $response["body"];
	}
	
}