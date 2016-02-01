<?php

namespace BadBehavior\SpamHaus;

// @todo this could be broken out to a separate namespace
// @todo use https://github.com/clash82/CachedHttpBl ?
class SpamHaus
{
	// The . on the end of this ensures PHP doesn't think it's a subdomain
	const DNS_QUERY_URI = 'zen.spamhaus.org.';
	const DOMAIN_URI = 'dbl.spamhaus.org.';

	/**
	 * @param string $ip
	 * @return Result
	 */
	public function query($ip)
	{
		$result = $this->dnsQuery($ip);
		return new Result($result);
	}

	/**
	 * @param string $ip
	 * @return array|bool an array of IPv4 addresses or false if hostname could not be resolved.
	 */
	public function dnsQuery($ip)
	{
		// @todo implement caching
		return gethostbynamel($this->getDNSQueryString($ip));
	}

	/**
	 * @param $domain
	 * @return array|bool an array of IPv4 addresses or false if hostname could not be resolved.
	 */
	public function domainQuery($domain)
	{
		return gethostbynamel($domain . '.' . self::DOMAIN_URI);
	}

	/**
	 * @param string $ip
	 * @return string
	 */
	protected function getDNSQueryString($ip)
	{
		return $this->reverseIp($ip) . '.' . self::DNS_QUERY_URI;
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