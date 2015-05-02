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
}