<?php

namespace BadBehavior;

class HttpBLResult
{
	// @todo move to separate class?
	const SEARCH_ENGINE = 0;
	const SUSPICIOUS = 1;
	const HARVESTER = 2;
	const SUSPICIOUS_AND_HARVESTER = 3;
	const COMMENT_SPAMMER = 4;
	const SUSPICIOUS_AND_COMMENT_SPAMMER = 5;
	const HARVESTER_AND_COMMENT_SPAMMER = 6;
	// @todo this is way too long
	const SUSPICIOUS_HARVESTER_AND_COMMENT_SPAMMER = 7;

	protected $octets = [];
	protected $is_valid = false;

	/**
	 * HttpBLResult constructor.
	 * @param array|bool $result
	 */
	public function __construct($result)
	{
		$this->is_valid = $result === false ? false : true;

		if ($this->is_valid)
		{
			$this->octets = explode('.', $result[0]);

			if (count($this->octets) != 4)
			{
				$this->is_valid = false;
			}
		}
	}

	/**
	 * @return bool if the result is valid
	 */
	public function isValid()
	{
		return $this->is_valid;
	}

	/**
	 * @return bool if the result contained an error
	 */
	public function hasError()
	{
		return $this->is_valid ? false : $this->octets[0] != '127';
	}

	/**
	 * @return bool|int
	 */
	public function activityAge()
	{
		if (!$this->is_valid)
		{
			return false;
		}

		return (int) $this->octets[1];
	}

	/**
	 * @return bool|int
	 */
	public function threatScore()
	{
		if (!$this->is_valid)
		{
			return false;
		}

		return (int) $this->octets[2];
	}

	/**
	 * @return bool|int
	 */
	public function requestType()
	{
		if (!$this->is_valid)
		{
			return false;
		}

		return (int) $this->octets[3];
	}

	/**
	 * @return bool
	 */
	public function isSearchEngine()
	{
		return $this->is_valid && $this->requestType() === self::SEARCH_ENGINE;
	}

	/**
	 * @return bool|string
	 */
	public function searchEngineName()
	{
		if (!$this->is_valid || !$this->isSearchEngine())
		{
			return false;
		}

		$serials = $this->getSearchEngineSerials();

		return isset($serials[$this->octets[2]]) ? $serials[$this->octets[2]] : false;
	}

	/**
	 * @return array
	 */
	protected function getSearchEngineSerials()
	{
		return [
			0 => 'Undocumented',
			1 => 'Altavista',
			2 => 'Ask',
			3 => 'Baidu',
			4 => 'Excite',
			5 => 'Google',
			6 => 'Looksmart',
			7 => 'Lycos',
			8 => 'MSN',
			9 => 'Yahoo',
			10 => 'Cuil',
			11 => 'InfoSeek',
			12 => 'Miscellaneous',
		];
	}
}