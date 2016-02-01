<?php

namespace BadBehavior\SpamHaus;

class Result
{
	protected $result = [];
	protected $is_valid = false;

	/**
	 * @param array|bool $result
	 */
	public function __construct($result)
	{
		$this->is_valid = empty($result) ? false : true;
	}

	/**
	 * @return bool if the result is valid
	 */
	public function isValid()
	{
		return $this->is_valid;
	}

	/**
	 * @param string $code One of the ResultCodes constants
	 * @return bool
	 */
	public function hasResultCode($code)
	{
		return $this->is_valid && in_array($code, $this->result);
	}
}