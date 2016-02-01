<?php

namespace BadBehavior;

class Request implements RequestInterface
{
	protected $headers = [];
	protected $request_uri;
	protected $request_entity = [];
	/** @var string[] */
	protected $known_proxies = [];

	/** @var  IP */
	protected $ip;

	public function __construct()
	{
		$this->loadHeaders();
	}

	/**
	 * @return IP
	 */
	public function getIP()
	{
		if ($this->ip === null)
		{
			$this->ip = new IP($this->loadIP());
		}

		return $this->ip;
	}

	/**
	 * Set the known reverse proxies
	 * Remember to run loadIP() after this
	 * @param array $proxies
	 * @return $this
	 */
	public function setKnownProxies(array $proxies)
	{
		$this->known_proxies = $proxies;
		$this->ip = null;
		return $this;
	}

	/**
	 * @return string
	 */
	public function loadIP()
	{

	}

	public function getRequestURI()
	{
		if ($this->request_uri === null)
		{
			$this->request_uri = $_SERVER['REQUEST_URI'];

			// IIS
			if (!$this->request_uri)
			{
				$this->request_uri = $_SERVER['SCRIPT_NAME'];
			}
		}

		return $this->request_uri;
	}

	/**
	 * @return array
	 */
	public function getRequestEntity()
	{
		// Reconstruct the HTTP entity, if present.
		if (!strcasecmp($_SERVER['REQUEST_METHOD'], "POST") || !strcasecmp($_SERVER['REQUEST_METHOD'], "PUT")) {
			foreach ($_POST as $h => $v) {
				$this->request_entity[$h] = $v;
			}
		}

		return $this->request_entity;
	}

	/**
	 * @return string
	 */
	public function getUserAgent()
	{

	}

	/**
	 * @param string $header
	 * @return bool
	 */
	public function hasHeader($header)
	{
		return isset($this->headers[$header]);
	}

	/**
	 * @param string $header
	 * @return string
	 */
	public function getHeader($header)
	{
		return $this->headers[$header];
	}

	/**
	 * @return bool
	 */
	public function isReverseProxy()
	{

	}

	/**
	 * @return array|false
	 */
	protected function loadHeaders()
	{
		// The old version used some shim for when getallheaders() isn't callable. If it's not, there should be a compatibility file to shim getallheaders()
		$headers = getallheaders();

		foreach ($headers as $key => $header)
		{
			$this->headers[str_replace('_', '-', strtolower($key))] = $header;
		}

		return $this->headers;
	}
}