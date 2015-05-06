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
     *   semester currently on Testudo. See http://api.umd.io/v0/courses?semester=012345 for 
     *   a list of available semesters. Does not support multiple values. 
     *   Does not support non-standard comparison operators
     * - string page : Optional. Pagination is supported and is 1-based, defaults to
     *   first page. Does not support non-standard comparison operators.
     * - string per_page: Optional. Number of items per page, defaults to 30. Does not 
     *   support non-standard comparison operators.
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

		$response = $this->request->api('GET', '/v0/courses/list?' . $queryString, array(), $headers);
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
     *   semester currently on Testudo. See http://api.umd.io/v0/courses?semester=012345 for 
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
     * - string name : Optional. String name of the course. Does not support non-standard
     *   comparison operators.
     * - string dept_id : Optional. Four letter string representation of the department. Examples
     *   include ENGL or BMGT. Does not support non-standard comparison operators.
     * - string department : Optional. Full name of the department that offers the course. Does not
     *   support non-standard comparison operators.
     * - string credits : Optional. One digit number of credits the course is worth. 
     *   Supports all comparison operators.
     * - array grading_method : Optional. Array of string grading options available. 
     *   The possible options are “Regular”, “Pass-Fail”, “Audit”, and “Sat-Fail”.
     *   Does not support non-standard comparison operators.
     * - array core : Optional. Array of strings of CORE requirements filled by a course.
     *   Does not support non-standard comparison operators.
     * - array gen_ed : Optional. Array of strings of GEN. ED requirements filled by a course.
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

		$response = $this->request->api('GET', '/v0/courses?' . $queryString, array(), $headers);
		return $response["body"];
	}
	/*
	 *
	 * Sections Endpoint
	 * http://api.umd.io/v0/courses/sections
	 *
	 */
	/**
     * Get data about all sections for the given semester
     * http://api.umd.io/v0/courses/sections
     * for more information see http://umd.io/courses/#sections
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
     *   semester currently on Testudo. See http://api.umd.io/v0/courses?semester=012345 for 
     *   a list of available semesters. Does not support multiple values. 
     *   Does not support non-standard comparison operators
     * - string page : Optional. Pagination is supported and is 1-based, defaults to
     *   first page. Does not support non-standard comparison operators.
     * - string per_page: Optional. Number of items per page, defaults to 30. Does not 
     *   support non-standard comparison operators.
     *
     * @return array|object : The response body. Contains one or more Section objects
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/courses/#section_object
	 */
	public function getAllSections($params = array())
	{	
		$queryString = $this->convertParamsToQueryString($params);

		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/sections?' . $queryString, array(), $headers);
		return $response["body"];
	}
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
		$sectionIds = urlencode(implode(',', (array) $sectionIds));

		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/sections/' . $sectionIds, array(), $headers);
		return $response["body"];
	}
	/**
     * Get data about certain sections using section properties
     * http://api.umd.io/v0/courses/sections
     * for more information see http://umd.io/courses/#sections
     * If a query string is formatted : http://api.umd.io/v0/courses/sections?<key>=<value>
     * then $params = array("<key>" => array("comparison" => "=", "value" => "<value>");
     *
     * If a query string supports comparison operators such as "!=", "<", "<=", ">", ">="
     * then a query string reading : http://api.umd.io/v0/courses/sections?<key>!=<value> becomes
     * $params = array("<key>" => array("comparison" => "!=", "value" => "<value>"));
     *
     * If a query string supports comma-separated values, add them to the "value" parameter as 
     * an indexed array. For example : http://api.umd.io/v0/courses/sections?<key>=<value1>,<value2>
     * becomes : $params = array("<key>" => array("comparison") => "=", 
     * "value" => array("value1", "value2"));
     *
     * If a query string supports the use of the pipe operator, add a key to the array
     * containing the comparison operator with the key "includeAllValues", with the value
     * of true.
     * For example : http://api.umd.io/v0/courses/sections?<key>=<value1>|<value2>
     * becomes : $params = array("<key>" => array("comparison") => "=", 
     * "value" => array("value1", "value2"), "includeAllValues" => true);
     *
     * @param array $params : An associative array parameters to be included in the
     * query string. If no parameters are passed in, will return an array of sections for 
     * the current semester.
     * - string semester : Optional. a six-digit string <year><month>, defaults to 
     *   semester currently on Testudo. See http://api.umd.io/v0/courses?semester=012345 for 
     *   a list of available semesters.
     * - string page : Optional. Pagination is supported and is 1-based, defaults to
     *   first page. Does not support non-standard comparison operators.
     * - string per_page: Optional. Number of items per page, defaults to 30. Does not 
     *   support non-standard comparison operators.
     * - string section_id : Optional. The related course_id with a four digit section number
     *   appended to it. Does not support non-standard comparison operators.
     * - string course_id :
     * - array instructors :
     * - string seats : Optional. The total number of seats offered in a section.
     *   Supports all comparison operators.
     *
     * -- The following parameters apply to a single meeting of a section --
     *
     * - string days : Optional. The days for meetings of the section i.e. MWF or TuTh. 
     *   Does not support non-standard comparison operators.
     * - string start_time : Optional. Start time of the meeting i.e. 9:00am. Does not support
     *   non-standard comparison operators.
     * - string end_time : Optional. End time of the meeting. Does not support
     *   non-standard comparison operators.
     * - string building : Optional. Building where the meeting takes place. See
     *   http://umd.io/map/#building_object for more information. Does not support
     *   non-standard comparison operators.
     * - string room: Optional. Four digit room code where the meeting takes place.
     *   Does not support non-standard comparison operators.
     * - string classtype: Optional. String indicates what type of meeting.
     *   Possible options are “Lecture”, “Discussion”, or “Lab”. Does not support
     *   non-standard comparison operators.
     *
     * @return array|object : The response body. Contains one or more Section objects
     * Type is controlled by Request::setReturnAssoc().
     * More information can be found at http://umd.io/courses/#section_object
	 */
	public function searchSections($params = array())
	{	
		$queryString = $this->convertParamsToQueryString($params);

		$headers = $this->headers();

		$response = $this->request->api('GET', '/v0/courses/sections?' . $queryString, array(), $headers);
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
