<?php

namespace BadBehavior;

interface RequestInterface
{
	/** @return IP */
	public function getIp();

	/** @return string */
	public function getRequestUri();

	/** @return string */
	public function getUserAgent();

	/** @return bool */
	public function hasHeader($header);

	/** @return string */
	public function getHeader($header);

	/** @return bool */
	public function isReverseProxy();
}