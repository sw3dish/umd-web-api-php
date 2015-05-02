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
	 * http://api.umd.io/v0/courses
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
     * More information can be found at http://umd.io/courses/#list_courses
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
     * http://api.umd.io/v0/courses/<course_id>
     * for more information see http://umd.io/courses/#get_courses
     *
     * @param string|array $courseIds :
     * - string $courseIds : single course identifier
     * - array $courseIds : an array of course identifiers
     *
     * @return array|object : The response body. Contains one or more Course objects.
     * Type is controlled by Request::setReturnAssoc().
     * More information on Course object can be found at http://umd.io/courses/#course_object
	 */
	public function getCourses($courseIds)
	{
		$courseIds = implode(',', (array) $courseIds);
		$courseIds = urlencode($courseIds);
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/' . $courseIds, array(), $headers);
		return $response["body"];
	}
	/*
	 *
	 * Sections Endpoint
	 * http://api.umd.io/v0/courses/sections
	 *
	 */
	/**
     * Get data about one or more sections
     * http://api.umd.io/v0/courses/sections/<section_id>
     * for more information see http://umd.io/courses/#get_sections
     *
     * @param string|array $sectionIds :
     * - string $sectionIds : single section identifier
     *   always the related course_id with a four-digit section number appended to it
     * - array $sectionIds : an array of section identifiers
     *
     * @return array|object : The response body. Contains one or more Section objects.
     * Type is controlled by Request::setReturnAssoc().
     * More information on Section object can be found at http://umd.io/courses/#section_object
	 */
	public function getSections($sectionIds)
	{
		$sectionIds = implode(',', (array) $sectionIds);
		$sectionIds = urlencode($sectionIds);
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/sections/' . $sectionIds, array(), $headers);
		return $response["body"];
	}
	/*
	 *
	 * Departments Endpoint
	 * http://api.umd.io/v0/courses/departments
	 *
	 */
	/**
     * Get data about one or more departments
     * http://api.umd.io/v0/courses/departments
     * for more information see http://umd.io/courses/#get_departments
     *
     * @return array|object : The response body. Contains one or more department ids.
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/courses/#get_departments
	 */
	public function getAllDepartments()
	{
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/departments/', array(), $headers);
		return $response["body"];
	}
}
