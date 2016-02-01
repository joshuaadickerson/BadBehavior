<?php

namespace BadBehavior;

class Whitelist
{
	protected $request;
	protected $ips = [];
	protected $user_agents = [];
	protected $uris = [];

	public function __construct(RequestInterface $request, array $list)
	{
		$this->request = $request;
		$this->setList($list);
	}

	public function setList(array $list)
	{
		$this->ips = [];
		$this->user_agents = [];
		$this->uris = [];

		if (!empty($list['ips']))
		{
			foreach($list['ips'] as $ip)
			{
				$this->ips[] = new IP($ip);
			}
		}

		$this->uris = $list['uris'];
		$this->user_agents = $list['user_agents'];
	}

	public function checkIP()
	{
		foreach($this->ips as $ip)
		{

		}
	}

	public function checkUserAgent()
	{
		foreach($this->user_agents as $ua)
		{

		}
	}

	public function checkUri()
	{
		foreach($this->uris as $uri)
		{

		}
	}
}