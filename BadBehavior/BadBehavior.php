<?php

namespace BadBehavior;

class BadBehavior
{
	protected $settings = [];

	protected $superglobals = [
		'post'      => [],
		'cookie'    => [],
		'get'       => [],
		'server'    => [],
	];

	/** @var bool  */
	protected $strict = false;

	/** @var  PluginInterface */
	protected $plugin;

	/** @var  RequestInterface */
	protected $request;

	public function __construct(array $settings, array $globals = [])
	{
		$this->settings = $settings;

		$this->setSuperGlobals($globals);
	}

	public function setStrictMode($strict)
	{
		$this->strict = (bool) $strict;
		return $this;
	}

	public function setPlugin(PluginInterface $plugin)
	{
		$this->plugin = $plugin;
		return $this;
	}

	/**
	 * @return PluginInterface|bool
	 */
	protected function getPlugin()
	{
		return $this->plugin === null ? false : $this->plugin;
	}

	/**
	 * This is mainly used for testing, but you may also use this to extend the request
	 *
	 * @param RequestInterface $request
	 * @return $this
	 */
	public function setRequest(RequestInterface $request)
	{
		$this->request = $request;
		return $this;
	}

	protected function getRequest()
	{
		if ($this->request === null)
		{
			$this->request = new Request();
		}

		return $this->request;
	}

	public function screen($fatal = true)
	{
		$response = new Response();
		$whitelisted = $this->isWhiteListed();

		if (!$whitelisted)
		{
			$blacklist = $this->isBlackListed($fatal);

			if ($blacklist)
			{
				return $blacklist;
			}
		}

		return $response;
	}

	/**
	 * @return bool|string
	 */
	public function isWhiteListed()
	{
		if ($this->getPlugin())
		{
			$whitelist = $this->getPlugin()->getWhitelist();

			if (empty($whitelist))
			{
				return false;
			}
		}

		return false;
	}

	/**
	 * @return bool|string
	 */
	public function isBlackListed($fatal = true)
	{
		if ($this->spambots())
		{
			// ua hit = 17f4e8c8
			// url hit = 96c0bd29
			return true;
		}

		if ($this->httpbl())
		{
			// 2b021b1f
			return true;
		}

		$header_return = $this->malformedHeaders();
		if ($header_return)
		{
			return $header_return;
		}

		return false;
	}

	protected function spambots()
	{
		$spambots = new Spambots;
		return $spambots->isSpambot($this->request);
	}

	/**
	 * @return bool
	 */
	protected function httpbl()
	{
		if ($this->request->getIp()->isV6())
		{
			return false;
		}

		$httpbl = new HttpBL($this->settings['httpbl_key']);
		$result = $httpbl->query($this->request->getIp());


	}

	protected function malformedHeaders()
	{
		$headers = new MalformedHeaders($this->request);

		if ($headers->hasBadExpectHeader())
		{
			// a0105122
			return true;
		}

		if ($this->strict && $headers->hasBadPragmaHeader())
		{
			// 41feed15
			return true;
		}

		if ($headers->hasBadCookieHeader())
		{
			// 6c502ff1
			return true;
		}

		if ($this->strict && $headers->hasBadRequestUri())
		{
			// dfd9b1ad
			return true;
		}

		if ($headers->hasIISAttack())
		{
			// dfd9b1ad
			return true;
		}

		if ($this->strict && $headers->hasBadRangeHeader())
		{
			// 7ad04a8a
			return true;
		}

		if ($headers->hasContentRangeInRequestHeader())
		{
			// 7d12528e
			return true;
		}

		if ($this->strict && $headers->hasLowercaseViaHeader())
		{
			// 9c9e4979
			return true;
		}

		if ($headers->hasPinappleProxy())
		{
			// 939a6fbb
			return true;
		}

		if ($headers->hasBadTEHeader())
		{
			// 582ec5e4
			return true;
		}

		if ($headers->hasBadWordpressTrackback())
		{
			// e3990b47
			return true;
		}

		return false;
	}

	// @todo use filter_input()?
	protected function setSuperGlobals(array $globals = [])
	{
		foreach ($this->superglobals as $key => &$val)
		{
			if (isset($globals[$key]))
			{
				$val = $globals[$key];
			}
			else
			{
				$global_key = '_' . strtoupper($key);
				$val = $GLOBALS[$global_key];
			}
		}

		return $this;
	}
}