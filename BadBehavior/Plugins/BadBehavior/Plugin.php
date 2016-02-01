<?php

namespace BadBehavior\Plugins\BadBehavior;

use BadBehavior\Blacklisted;
use BadBehavior\PluginInterface;

class Plugin implements PluginInterface
{
	/** @var  Blacklisted */
	protected $blacklisted;

	public function getWhitelist()
	{

	}

	/**
	 * @return Blacklisted
	 */
	public function getBlacklisted()
	{
		return new Blacklisted();
	}
}