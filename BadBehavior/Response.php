<?php

namespace BadBehavior;

class Response
{
	/** @var string[]  */
	protected $errors = [];
	/** @var bool  */
	protected $whitelisted = false;
	/** @var bool  */
	protected $blacklisted = false;

	/**
	 * @param string|null $error
	 * @return bool
	 */
	public function hasError($error = null)
	{
		if ($error === null)
		{
			return !empty($errors);
		}

		return isset($this->errors[$error]);
	}

	/**
	 * @param string $error
	 * @return $this
	 */
	public function addError($error)
	{
		$this->errors[$error] = $error;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setBlacklisted()
	{
		$this->blacklisted = true;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setWhitelisted()
	{
		$this->whitelisted = true;
		return $this;
	}
}