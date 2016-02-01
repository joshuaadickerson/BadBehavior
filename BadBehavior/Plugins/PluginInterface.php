<?php

namespace BadBehavior;

use BadBehavior\Plugins\BlacklistedInterface;

interface PluginInterface
{
	public function getWhitelist();

	/**
	 * @return BlacklistedInterface
	 */
	public function getBlacklisted();
}