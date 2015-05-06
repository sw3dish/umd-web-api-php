<?php
namespace UMDWebAPI;

class Method
{
	protected $request;

	/**
	 * Constructor
	 * Sets up Request object
	 *
	 * @param Request $request: Optional. The Request object to use
	 * 
	 * @return void
	 */
	protected function __construct($request = null)
	{
		if (is_null($request)) {
			$request = new Request();
		}

		$this->request = $request;
	}
	/**
     * Add additional headers that may be implemented in later versions (such as auth, etc)
     * of the umd.io API i.e. authorization
     * As of v 0.1.0, none are needed 
     *
     * @return array: any additional headers.
     */
    protected function headers()
    {
        $headers = array();
        
        return $headers;
    }
    /**
	 * Convert params array into query string
	 * @see Course::searchCourses, Course::searchSections
	 *
	 * @param array $params : An associative array parameters to be included in the
     * query string.
     *
     * @return string : Query string to be used in the url of the api request.
	 */
	protected function convertParamsToQueryString($params = array())
	{
		//start with an empty string
		$queryString = "";
		//loop over our params array
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				//make sure, at the least, we have a key and value
				if (isset($key) && isset($value) && isset($value["value"])) {
					//add the key to the string
					$queryString .= urlencode(strtolower((String) $key));
					//if there's a comparison, add it, otherwise add "="
					if (isset($value["comparison"])) {
						$queryString .= (String) $value["comparison"];
					} else {
						$queryString .= "=";
					}
					//add the value to the string, after expanding the array if there is one.
					if (isset($value["includeAllValues"])) {
						$queryString .= urlencode(implode('|', (array) $value["value"]));	
					} else {
						$queryString .= urlencode(implode(',', (array) $value["value"]));	
					}
					
					//add a trailing &
					$queryString .= "&";
				}
			}
		}
		return $queryString;
	}
}
