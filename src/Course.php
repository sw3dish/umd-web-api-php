<?php
namespace UMDWebAPI;

class Course extends Method
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
	/*
	 *
	 * Courses Endpoint
	 * http://api.umd.io/v0/bus/courses
	 *
	 */
	/**
     * Get data about all courses for the given semester
     * http://api.umd.io/v0/courses
     * for more information see http://umd.io/courses/#list_courses
     *
     * @param array $params : An associative array parameters to be included in the
     * query string. 
     * - string semester : Optional. a six-digit string <year><month>, defaults to 
     *   current semester. See http://api.umd.io/v0/courses?semester=012345 for 
     *   a list of available semesters.
     *
     * @return array|object : The response body. Contains one or more objects with 
     * course_id, name, and department
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/bus/#locations
	 */
	public function getAllCourses($params = array())
	{	
		$params = http_build_query($params);

		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/courses?' . $params, array(), $headers);
		return $response["body"];
	}
	/**
     * Get data about one or more courses
     * http://api.umd.io/v0/courses/<route_id>
     * for more information see http://umd.io/courses/#get_routes
     *
     * @param string|array $courseIds :
     * - string $courseIds : single course identifier
     * - array $courseIds : an array of course identifiers
     *
     * @return array|object : The response body. Contains one or more Course objects.
     * Type is controlled by Request::setReturnAssoc().
     * More information on Course object can be found at http://umd.io/course/#course_object
	 */
	public function getCourses($courseIds)
	{
		$courseIds = implode(',', (array) $courseIds);
		$courseIds = urlencode($courseIds);
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/' . $courseIds, array(), $headers);
		return $response["body"];
	}

}
