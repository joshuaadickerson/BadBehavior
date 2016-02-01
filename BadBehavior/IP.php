<?php

namespace BadBehavior;

class IP
{
	const IP_V6 = 6;
	const IP_V4 = 4;
	const IP_ANY = 10;

	/** @var  string */
	protected $ip;

	/** @var  string */
	protected $hostname;

	/**
	 * @param string $ip
	 */
	public function __construct($ip)
	{
		$this->ip = (string) $ip;
	}

	/**
	 * @param int $version
	 * @return bool
	 * @throws \InvalidArgumentException when the version is not one of IP_V6, IP_V4, or IP_ANY
	 */
	public function isValid($version = self::IP_ANY)
	{
		if ($version === self::IP_V4 || $version === self::IP_ANY)
		{
			return $this->isV4();
		}

		if ($version === self::IP_V6 || $version === self::IP_ANY)
		{
			return $this->isV6();
		}

		throw new \InvalidArgumentException('$version must be one of IP_V6, IP_V4, or IP_ANY');
	}

	/**
	 * @return bool
	 */
	public function isV6()
	{

	}

	/**
	 * @return bool
	 */
	public function isV4()
	{

	}

	public function toV6()
	{
		if ($this->isV6())
		{
			return $this->ip;
		}


	}

	public function hostname()
	{
		return gethostbyaddr((string) $this->ip);
	}

	public function matchCidr($cidr)
	{
		$output = false;

		if (is_array($cidr))
		{
			foreach ($cidr as $cidrlet)
			{
				if ($this->matchCidr($cidrlet))
				{
					$output = true;
					break;
				}
			}
		} else {
			$cidr_array = explode('/', $cidr);

			if (empty($cidr_array[1]))
			{
				$ip = empty($cidr_array) ? $cidr : $cidr_array[0];
				$mask = 32;
			}
			else
			{
				list($ip, $mask) = $cidr_array;
			}

			$mask = pow(2, 32) - pow(2, (32 - $mask));
			$output = ((ip2long($this->ip) & $mask) == (ip2long($ip) & $mask));
		}

		return $output;
	}

	/**
	 * @return bool
	 */
	public function isRFC1918()
	{
		return $this->matchCidr([
			'10.0.0.0/8',
			'172.16.0.0/12',
			'192.168.0.0/16'
		]);
	}

	/**
	 * @param $start
	 * @param $end
	 * @return bool
	 */
	public function between($start, $end)
	{

	}

	public function __toString()
	{
		return $this->ip;
	}
}