<?php


namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


/**
 * Session Controller.
 */
final class SessionController extends BaseController
{


	/**
	 * Read current user session status and info.
	 *
	 * @param Request  $request
	 * @param Response $response
	 * @return Response
	 */
	function read(Request $request, Response $response): Response
	{
		// TODO implement me
	}


	/**
	 * Create a user session and return an access token.
	 *
	 * @param Request  $request
	 * @param Response $response
	 * @return Response
	 */
	function create(Request $request, Response $response): Response
	{
		// TODO implement me
	}


}
