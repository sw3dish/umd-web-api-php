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
     * If a query string is formatted : http://api.umd.io/v0/courses?<key>=<value>
     * then $params = array("<key>" => array("comparison" => "=", "value" => "<value>");
     *
     * If a query string supports comparison operators such as "!=", "<", "<=", ">", ">="
     * then a query string reading : http://api.umd.io/v0/courses?<key>!=<value> becomes
     * $params = array("<key>" => array("comparison" => "!=", "value" => "<value>"));
     *
     * If a query string supports comma-separated values, add them to the "value" parameter as 
     * an indexed array. For example : http://api.umd.io/v0/courses?<key>=<value1>,<value2>
     * becomes : $params = array("<key>" => array("comparison") => "=", 
     * "value" => array("value1", "value2"));
     *
     * If a query string supports the use of the pipe operator, add a key to the array
     * containing the comparison operator with the key "includeAllValues", with the value
     * of true.
     * For example : http://api.umd.io/v0/courses?<key>=<value1>|<value2>
     * becomes : $params = array("<key>" => array("comparison") => "=", 
     * "value" => array("value1", "value2"), "includeAllValues" => true);
     *
     * @param array $params : Optional. An associative array parameters to be included in the
     * query string. If no parameters are passed in, will return an array of courses for 
     * the current semester.
     * - string semester : Optional. a six-digit string <year><month>, defaults to 
     *   current semester. See http://api.umd.io/v0/courses?semester=012345 for 
     *   a list of available semesters. Does not support multiple values. 
     *   Does not support non-standard comparison operators
     *
     * @return array|object : The response body. Contains one or more objects with 
     * course_id, name, and department
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/courses/#list_courses
	 */
	public function getAllCourses($params = array())
	{	
		$queryString = $this->convertParamsToQueryString($params);

		$headers = $this->headers();

		$response = $this->request->api('GET', 'v0/courses/list?' . $queryString, array(), $headers);
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
		$courseIds = urlencode(implode(',', (array) $courseIds));
		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/' . $courseIds, array(), $headers);
		return $response["body"];
	}
	/**
     * Get data about certain courses using course properties
     * http://api.umd.io/v0/courses
     * for more information see http://umd.io/courses/#search
     * If a query string is formatted : http://api.umd.io/v0/courses?<key>=<value>
     * then $params = array("<key>" => array("comparison" => "=", "value" => "<value>");
     *
     * If a query string supports comparison operators such as "!=", "<", "<=", ">", ">="
     * then a query string reading : http://api.umd.io/v0/courses?<key>!=<value> becomes
     * $params = array("<key>" => array("comparison" => "!=", "value" => "<value>"));
     *
     * If a query string supports comma-separated values, add them to the "value" parameter as 
     * an indexed array. For example : http://api.umd.io/v0/courses?<key>=<value1>,<value2>
     * becomes : $params = array("<key>" => array("comparison") => "=", 
     * "value" => array("value1", "value2"));
     *
     * If a query string supports the use of the pipe operator, add a key to the array
     * containing the comparison operator with the key "includeAllValues", with the value
     * of true.
     * For example : http://api.umd.io/v0/courses?<key>=<value1>|<value2>
     * becomes : $params = array("<key>" => array("comparison") => "=", 
     * "value" => array("value1", "value2"), "includeAllValues" => true);
     *
     * @param array $params : An associative array parameters to be included in the
     * query string. If no parameters are passed in, will return an array of courses for 
     * the current semester.
     * - string semester : Optional. a six-digit string <year><month>, defaults to 
     *   current semester. See http://api.umd.io/v0/courses?semester=012345 for 
     *   a list of available semesters.
     * - string page : Optional. Pagination is supported and is 1-based, defaults to
     *   first page. Does not support non-standard comparison operators.
     * - string per_page: Optional. Number of items per page, defaults to 30. Does not 
     *   support non-standard comparison operators.
     * - string expand: Optional. Only valid value is sections. Will expand Section objects 
     *   response body. Does not support non-standard comparison operators.
     * - string course_id : Optional. A unique string ID with a four letter dept_id
     *   followed by a three digit course number and an optional letter. Does not support 
     *   non-standard comparison operators.
     * - string name : Optional string name of the course. Does not support non-standard
     *   comparison operators.
     * - string dept_id : Four letter string representation of the department. Examples
     *   include ENGL or BMGT. Does not support non-standard comparison operators.
     * - string department : Full name of the department that offers the course. Does not
     *   support non-standard comparison operators.
     * - string semester : Six-digit number identifying the semester the course is offered. 
     *   Does not support non-standard comparison operators.
     * - string credits : One digit number of credits the course is worth. 
     *   Supports all comparison operators.
     * - array grading_method : Array of string grading options available. 
     *   The possible options are “Regular”, “Pass-Fail”, “Audit”, and “Sat-Fail”.
     *   Does not support non-standard comparison operators.
     * - array core : Array of strings of CORE requirements filled by a course.
     *   Does not support non-standard comparison operators.
     * - array gen_ed : Array of strings of GEN. ED requirements filled by a course.
     *   Does not support non-standard comparison operators.
     *
     * @return array|object : The response body. Contains one or more Course objects
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/courses/#course_object
	 */
	public function searchCourses($params = array())
	{	
		$queryString = $this->convertParamsToQueryString($params);
		$headers = $this->headers();
		return $queryString;
		$response = $this->request->api('GET', 'v0/courses?' . $queryString, array(), $headers);
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
	/**
	 *
	 * Helper functions 
	 *
	 */
	/**
	 * Convert params array into query string
	 * @see searchCourses, searchSections
	 *
	 * @param array $params : An associative array parameters to be included in the
     * query string.
     *
     * @return string : Query string to be used in the url of the api request.
	 */
	private function convertParamsToQueryString($params = array())
	{
		//start with an empty string
		$queryString = "";
		//loop over our params array
		foreach ($params as $key => $value) {
			//make sure, at the least, we have a key and value
			if (isset($key) && isset($value) && isset($value["value"])) {
				//add the key to the string
				$queryString .= urlencode(strtolower((String) $key));
				//if there's a comparison, add it, otherwise add "="
				if (isset($value["comparison"])) {
					$queryString .= urlencode(strtolower((String) $value["comparison"]));
				} else {
					$queryString .= "%3D";
				}
				//add the value to the string, after expanding the array if there is one.
				if (isset($value["includeAllValues"])) {
					$queryString .= urlencode(implode('|', (array) $value["value"]));	
				} else {
					$queryString .= urlencode(implode(',', (array) $value["value"]));	
				}
				
				//add a trailing &
				$queryString .= "%26";
			}
		}
		return $queryString;
	}
}
