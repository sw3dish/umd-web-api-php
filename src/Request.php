<?php
namespace UMDWebAPI;

class Request
{
	private $returnAssoc = false;

	const API_URL = 'http://api.umd.io';

	/**
	 * Make a request to the "api" endpoint.
	 * (Building out to support different endpoints in the future)
	 *
	 * @param string $method : The HTTP method to use.
	 * @param string $uri : The URI to request
	 * @param array $parameters : Optional. Query parameters
	 * @param array $headers : Optional. HTTP headers
	 *
	 * @return array Response data:
	 * - array|object body: The response body. Type is controlled by Request::setReturnAssoc().
	 * - string headers: Response headers.
	 * - int status: HTTP status code.
	 */
	public function api($method, $uri, $parameters = array(), $headers = array())
	{
		return $this->send($method, self::API_URL . $uri, $parameters, $headers);
	}
    /**
     * Make a request to umd.io
     * Consider using one of the convenience methods (currently only api())
     *
     * @param string $method: The HTTP method to use.
     * @param string $string: The URL to request.
     * @param array $parameters: Optional. Query parameters.
     * @param array $headers: Optional HTTP headers.
     *
     * @return array Response data:
     * - array|object body: The response body. Type is controlled by Request::setReturnAssoc().
     * - string headers: Response headers.
     * - int status: HTTP status code.
     */
    public function send($method, $url, $parameters = array(), $headers = array())
    {
    	// Sometimes a JSON object is passed
        if (is_array($parameters) || is_object($parameters)) {
            $parameters = http_build_query($parameters);
        }

        $mergedHeaders = array();
        foreach ($headers as $key => $val) {
            $mergedHeaders[] = "$key: $val";
        }

        $options = array(
        	CURLOPT_HEADER => true,
        	CURLOPT_HTTPHEADER => $mergedHeaders,
            CURLOPT_RETURNTRANSFER => true
        );

        //trim the url, just in case
        $url = rtrim($url, '/');
        //change case to uppercase for upcoming switch
        $method = strtoupper($method);

        switch ($method) {
            case 'DELETE':
                $options[CURLOPT_CUSTOMREQUEST] = $method;
                $options[CURLOPT_POSTFIELDS] = $parameters;
                break;
            case 'POST':
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = $parameters;
                break;
            case 'PUT':
                $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $options[CURLOPT_POSTFIELDS] = $parameters;
                break;
            default:
                $options[CURLOPT_CUSTOMREQUEST] = $method;
                if ($parameters) {
                    $url .= '/?' . $parameters;
                }
                break;
        }

        $options[CURLOPT_URL] = $url;

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        list($headers, $body) = explode("\r\n\r\n", $response, 2);

        $body = json_decode($body, $this->returnAssoc);

        if ($status < 200 || $status > 299) {

        	$error = $body;

        	if (!$this->returnAssoc && isset($error->error_code)) {           
                // These properties only exist on API calls, not auth calls
                if (isset($error->message) && isset($error->error_code)) {
                    throw new UMDWebAPIException($error->message, $error->error_code);
                } elseif (isset($error->message)) {
                	throw new UMDWebAPIException($error->message, $status);            
                } else {
                	throw new UMDWebAPIException($error, $status);
                }
            } elseif ($this->returnAssoc && isset($error['error_code'])) {
                // These properties only exist on API calls, not auth calls
                if (isset($error['message']) && isset($error['error_code'])) {
                    throw new UMDWebAPIException($error['message'], $error['error_code']);
                } elseif (isset($error['message'])) {
                	throw new UMDWebAPIException($error['message'], $status)
                } else {
                    throw new UMDWebAPIException($error, $status);
                }
            } else {
                throw new UMDWebAPIException('No \'error\' provided in response body', $status);
            }
        }

        return array(
            'body' => $body,
            'headers' => $headers,
            'status' => $status,
        );
    }
    /**
     * Set the return type for the response body.
     *
     * @param bool: $returnAssoc Whether to return an associative array or an stdClass.
     *
     * @return void
     */
    public function setReturnAssoc($returnAssoc)
    {
        $this->returnAssoc = $returnAssoc;
    }
    /**
     * Get a value indicating the response body type.
     *
     * @return bool: Whether the body is returned as an associative array or an stdClass.
     */
    public function getReturnAssoc()
    {
        return $this->returnAssoc;
    }
}
