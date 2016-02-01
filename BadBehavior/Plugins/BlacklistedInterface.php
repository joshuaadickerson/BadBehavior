<?php

namespace BadBehavior\Plugins;

use BadBehavior\RequestInterface;
use BadBehavior\Response;

interface BlacklistedInterface
{
	/**
	 * @param RequestInterface $request
	 * @param Response $response
	 * @return mixed
	 */
	public function log(RequestInterface $request, Response $response);

	/**
	 * @param RequestInterface $request
	 * @param Response $response
	 * @return mixed
	 */
	public function gc(RequestInterface $request, Response $response);

	/**
	 * @param RequestInterface $request
	 * @param Response $response
	 * @return mixed
	 */
	public function display(RequestInterface $request, Response $response);
}