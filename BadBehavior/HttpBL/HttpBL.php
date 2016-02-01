<?php

namespace BadBehavior;

// @todo this could be broken out to a separate namespace
// @todo use https://github.com/clash82/CachedHttpBl ?
class HttpBL
{
	// The . on the end of this ensures PHP doesn't think it's a subdomain
	const DNS_QUERY_URI = 'dnsbl.httpbl.org.';

	/** @var  string */
	protected $api_key;

	/**
	 * HttpBL constructor.
	 * @param string $api_key
	 */
	public function __construct($api_key)
	{
		if (empty($api_key))
		{
			throw new \RuntimeException('Invalid http:BL API key');
		}
	}

	/**
	 * @param string $ip
	 * @return HttpBLResult
	 */
	public function query($ip)
	{
		$result = $this->dnsQuery($ip);
		return new HttpBLResult($result);
	}

	/**
	 * @param string $ip
	 * @return array|bool
	 */
	public function dnsQuery($ip)
	{
		// @todo implement caching
		return gethostbynamel($this->getDNSQueryString($ip));
	}

	/**
	 * @param string $ip
	 * @return string
	 */
	protected function getDNSQueryString($ip)
	{
		return $this->api_key . $this->reverseIp($ip) . '.' . self::DNS_QUERY_URI;
	}

	/**
	 * @param string $ip
	 * @return string
	 */
	protected function reverseIp($ip)
	{
		return implode('.', array_reverse(explode('.', $ip)));
	}
}