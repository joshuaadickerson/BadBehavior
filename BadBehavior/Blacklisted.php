<?php

namespace BadBehavior;

class Blacklisted
{
	/** @var PluginInterface  */
	protected $plugin;

	public function __construct(PluginInterface $plugin = null)
	{
		$this->plugin = $plugin;
	}

	/**
	 * Log that this request is blacklisted
	 */
	public function log(RequestInterface $request, Response $response)
	{
		if ($this->plugin instanceof PluginInterface)
		{
			$this->plugin->getBlacklisted()->log($request, $response);
		}
	}

	/**
	 * Run garbage collection
	 */
	public function gc(RequestInterface $request, Response $response)
	{
		if ($this->plugin instanceof PluginInterface)
		{
			$this->plugin->getBlacklisted()->gc($request, $response);
		}
	}

	public function display(RequestInterface $request, Response $response)
	{
		if ($this->plugin instanceof PluginInterface)
		{
			$this->plugin->getBlacklisted()->display($request, $response);
		}
	}
}