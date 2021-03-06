<?php
/**
 * This file contains code about maxh\Nominatim\Exceptions\NominatimException class
 */

namespace maxh\Nominatim\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * InvalidParameterException exception is thrown when a request failed because of a bad client configuration
 *
 * InvalidParameterException appears when the request failed because of a bad parameter from
 * the client request.
 *
 * @package maxh\Nominatim
 * @category Exceptions
 */
class NominatimException extends \Exception
{

	/**
	 * Contain the request
	 * @var RequestInterface
	 */
	private $request;

	/**
	 * Contain the response
	 * @var ResponseInterface
	 */
	private $response;
	
	/**
	 * Constructor
	 * @param string                 $message  Message of this exception
	 * @param RequestInterface       $request  The request instance
	 * @param ResponseInterface|null $response The response of the request
	 * @param \Exception|null        $previous Exception object
	 */
	public function __construct(
		$message,
		RequestInterface $request,
		ResponseInterface $response = null,
		\Exception $previous = null
	) {
		// Set the code of the exception if the response is set and not future.
		$code = $response && !($response instanceof PromiseInterface) ? $response->getStatusCode() : 0;

		parent::__construct($message, $code, $previous);

		$this->request = $request;
		$this->response = $response;

	}

	/**
	 * Return the Request
	 * @return GuzzleHttp\Psr7\Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Return the Response
	 * @return GuzzleHttp\Psr7\Response [description]
	 */
	public function getResponse()
	{
		return $this->response;
	}
}