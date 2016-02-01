<?php

namespace BadBehavior;

class SearchEngines
{
	/** @var  RequestInterface */
	protected $request;

	/**
	 * SearchEngines constructor.
	 * @param RequestInterface $request
	 */
	public function __construct(RequestInterface $request)
	{
		$this->request = $request;
	}

	/**
	 * @param array $ips
	 * @return bool
	 */
	protected function searchEngineCheck(array $ips)
	{
		// Search engines don't use IPv6 I guess
		if ($this->request->getIp()->isV6()) {
			return false;
		}

		if ($this->request->getIp()->matchCidr($ips) === false) {
			return true;
		}

		return false;
	}

	public function isBaidu()
	{
		$ips = [
			"119.63.192.0/21",
			"123.125.71.0/24",
			"180.76.0.0/16",
			"220.181.0.0/16",
		];

		return $this->searchEngineCheck($ips);
	}

	public function isGoogle()
	{
		$ips = [
			"66.249.64.0/19",
			"64.233.160.0/19",
			"72.14.192.0/18",
			"203.208.32.0/19",
			"74.125.0.0/16",
			"216.239.32.0/19",
			"209.85.128.0/17",
		];

		return $this->searchEngineCheck($ips);
	}

	public function isMSNBot()
	{
		$ips = [
			"207.46.0.0/16",
			"65.52.0.0/14",
			"207.68.128.0/18",
			"207.68.192.0/20",
			"64.4.0.0/18",
			"157.54.0.0/15",
			"157.60.0.0/16",
			"157.56.0.0/14",
			"131.253.21.0/24",
			"131.253.22.0/23",
			"131.253.24.0/21",
			"131.253.32.0/20",
			"40.76.0.0/14",
		];

		return $this->searchEngineCheck($ips);
	}

	public function isYahoo()
	{
		$ips = [
			"202.160.176.0/20",
			"67.195.0.0/16",
			"203.209.252.0/24",
			"72.30.0.0/16",
			"98.136.0.0/14",
			"74.6.0.0/16",
		];

		return $this->searchEngineCheck($ips);
	}
}