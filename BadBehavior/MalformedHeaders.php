<?php

namespace BadBehavior;

class MalformedHeaders
{
	/** @var Request  */
	protected $request;

	/**
	 * MalformedHeaders constructor.
	 * @param RequestInterface $request
	 */
	public function __construct(RequestInterface $request)
	{
		$this->request = $request;
	}

	/**
	 * @return bool
	 */
	public function hasBadExpectHeader()
	{
		// We should never see Expect: for HTTP/1.0 requests
		return $this->request->hasHeader('expect')
		&& stripos($this->request->getHeader('expect'), '100-continue') !== false
		&& $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.0';
	}

	/**
	 * @return bool
	 */
	public function hasBadPragmaHeader()
	{
		// Is it claiming to be HTTP/1.1?  Then it shouldn't do HTTP/1.0 things
		// Blocks some common corporate proxy servers in strict mode
		return $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1'
		&& $this->request->hasHeader('pragma')
		&& !$this->request->hasHeader('cache-control')
		&& stripos($this->request->getHeader('pragma'), 'no-cache') !== false;
	}

	/**
	 * @return bool
	 */
	public function hasBadCookieHeader()
	{
		// Enforce RFC 2965 sec 3.3.5 and 9.1
		// The only valid value for $Version is 1 and when present,
		// the user agent MUST send a Cookie2 header.
		// First-gen Amazon Kindle is broken; Amazon has been notified 9/24/08
		// NOTE: RFC 2965 is obsoleted by RFC 6265. Current software MUST NOT
		// use Cookie2 or $Version in Cookie.
		return $this->request->hasHeader('cookie')
		&& strpos($this->request->getHeader('cookie'), '$Version=0') !== false
		&& !$this->request->hasHeader('cookie2')
		&& strpos($this->request->getUserAgent(), 'Kindle/') === false;
	}

	/**
	 * @return bool
	 */
	public function emptyUserAgent()
	{
		return $_SERVER['REQUEST_METHOD'] && $this->request->getUserAgent() == '';
	}

	/**
	 * @return bool
	 */
	public function hasBadRequestUri()
	{
		// Broken spambots send URLs with various invalid characters
		// Some broken browsers send the #vector in the referer field :(
		// Worse yet, some Javascript client-side apps do the same in
		// blatant violation of the protocol and good sense.
		return strpos($_SERVER['REQUEST_URI'], '#') !== false;
	}

	/**
	 * @return bool
	 * @todo this isn't a malformed header
	 */
	public function hasIISAttack()
	{
		// A pretty nasty SQL injection attack on IIS servers
		return stripos($_SERVER['REQUEST_URI'], ';DECLARE%20@') !== false;
	}

	/**
	 * @return bool
	 */
	public function hasBadRangeHeader()
	{
		// Range: field exists and begins with 0
		// Real user-agents do not start ranges at 0
		// NOTE: this blocks the whois.sc bot. No big loss.
		// Exceptions: MT (not fixable); LJ (refuses to fix; may be
		// blocked again in the future); Facebook
		return $this->request->hasHeader('range')
		&& strpos($this->request->getHeader('range'), '=0-') !== false
		&& strncmp($this->request->getUserAgent(), 'MovableType', 11)
		&& strncmp($this->request->getUserAgent(), 'URI::Fetch', 10)
		&& strncmp($this->request->getUserAgent(), "php-openid/", 11)
		&& strncmp($this->request->getUserAgent(), "facebookexternalhit", 19);
	}

	/**
	 * @return bool
	 */
	public function hasContentRangeInRequestHeader()
	{
		return $this->request->hasHeader('content-range');
	}

	/**
	 * @return bool
	 * @todo I don't think this is a malformed header
	 */
	public function hasLowercaseViaHeader()
	{
		// This is actually a weird one because we need to know the case

		/*
	// Lowercase via is used by open proxies/referrer spammers
	// Exceptions: Clearswift uses lowercase via (refuses to fix;
	// may be blocked again in the future)
	if ($settings['strict'] &&
		array_key_exists('via', $package['headers']) &&
		strpos($package['headers']['via'],'Clearswift') === FALSE &&
		strpos($ua,'CoralWebPrx') === FALSE) {
		return "9c9e4979";
	}
	}
		 */
	}

	/**
	 * @return bool
	 * @todo this isn't a malformed header
	 */
	public function hasPinappleProxy()
	{
		// pinappleproxy is used by referrer spammers
		return $this->request->hasHeader('via') && (
			stripos($this->request->getHeader('via'), 'pinappleproxy') !== false
			|| stripos($this->request->getHeader('via'), 'PCNETSERVER') !== false
			|| stripos($this->request->getHeader('via'), 'Invisiware') !== false
		);
	}

	public function hasBadTEHeader()
	{
		return $this->request->hasHeader('te')
		&& !preg_match('/\bTE\b/', $this->request->getHeader('te'));
	}

	public function hasBadWordpressTrackback()
	{
		// Fake WordPress trackbacks
		// Real ones do not contain Accept:, and have a charset defined
		// Real WP trackbacks may contain Accept: depending on the HTTP transport being used by the sending host
		return $this->request->hasHeader('content-type')
			&& strpos($this->request->getUserAgent(), 'wordpress') !== false
			&& strpos($this->request->getHeader('content-type'), 'charset=') !== false;
	}
}