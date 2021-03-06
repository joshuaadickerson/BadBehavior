<?php

namespace BadBehavior;

class Spambots
{
	public $ua_start_strings = array(
		'8484 Boston Project',	// video poker/porn spam
		'ArchiveTeam',	// ignores robots.txt and hammers server
		'adwords',		// referrer spam
		'autoemailspider',	// spam harvester
		'blogsearchbot-martin',	// from honeypot
		'BrowserEmulator/',	// open proxy software
		'CherryPicker',		// spam harvester
		'core-project/',	// FrontPage extension exploits
		'Diamond',		// delivers spyware/adware
		'Digger',		// spam harvester
		'ecollector',		// spam harvester
		'EmailCollector',	// spam harvester
		'Email Siphon',		// spam harvester
		'EmailSiphon',		// spam harvester
		'Forum Poster',		// forum spambot
		'grub crawler',		// misc comment/email spam
		'HttpProxy',		// misc comment/email spam
		'Internet Explorer',	// XMLRPC exploits seen
		'ISC Systems iRc',	// spam harvester
		'Jakarta Commons',	// customised spambots
		'Java 1.',		// unidentified robots
		'Java/1.',		// unidentified robots
		'libwww-perl',		// unidentified robots
		'LWP',			// unidentified robots
		'lwp',			// unidentified robots
		'Microsoft Internet Explorer/',	// too old; assumed robot
		'Microsoft URL',	// unidentified robots
		'Missigua',		// spam harvester
		'MJ12bot/v1.0.8',	// malicious botnet
		'Morfeus',		// vulnerability scanner
		'Movable Type',		// customised spambots
		//'Mozilla ',		// malicious software
		'Mozilla/0',		// malicious software
		'Mozilla/1',		// malicious software
		'Mozilla/2',		// malicious software
		'Mozilla/3',		// malicious software
		'Mozilla/4.0(',		// from honeypot
		'Mozilla/4.0+(compatible;+',	// suspicious harvester
		'Mozilla/4.0 (Hydra)',	// brute force tool
		'MSIE',			// malicious software
		'MVAClient',		// automated hacking attempts
		'Nessus',		// vulnerability scanner
		'NutchCVS',		// unidentified robots
		'Nutscrape/',		// misc comment spam
		'OmniExplorer',		// spam harvester
		'Opera/9.64(',		// comment spam bot
		'PMAFind',		// vulnerability scanner
		'psycheclone',		// spam harvester
		'PussyCat ',		// misc comment spam
		'PycURL',		// misc comment spam
		'Python-urllib',	// commonly abused
		'revolt',		// vulnerability scanner
//		WP 2.5 now has Flash; FIXME
//		'Shockwave Flash',	// spam harvester
		'sqlmap/',		// SQL injection
		'Super Happy Fun ',	// spam harvester
		'TrackBack/',		// trackback spam
		'user',			// suspicious harvester
		'User Agent: ',		// spam harvester
		'User-Agent: ',		// spam harvester
		'w3af',			// vulnerability scanner
		'WebSite-X Suite',	// misc comment spam
		'Winnie Poh',		// Automated Coppermine hacks
		'Wordpress',		// malicious software
		'\'',			// malicious software
	);

	public $anywhere_ua_strings = array(
		'\r',			// A really dumb bot
		'<sc',              // XSS exploit attempts
		'; Widows ',		// misc comment/email spam
		'a href=',		// referrer spam
		'ArchiveBot',	// ignores robots.txt and hammers server
		'Bad Behavior Test',	// Add this to your user-agent to test BB
		'compatible ; MSIE',	// misc comment/email spam
		'compatible-',		// misc comment/email spam
		'DTS Agent',		// misc comment/email spam
		'Email Extractor',	// spam harvester
		'Firebird/',		// too old; assumed robot
		'Gecko/2525',		// revisit this in 500 years
		'grub-client',		// search engine ignores robots.txt
		'hanzoweb',		// very badly behaved crawler
		'Havij',		// SQL injection tool
		'Indy Library',		// misc comment/email spam
		'Ming Mong',		// brute force tool
		'MSIE 7.0;  Windows NT 5.2',	// Cyveillance
		'Murzillo compatible',	// comment spam bot
		'.NET CLR 1)',		// free poker, etc.
		'.NET CLR1',		// spam harvester
		'Netsparker',		// vulnerability scanner
		'Nikto/',		// vulnerability scanner
		'Perman Surfer',	// old and very broken harvester
		'POE-Component-Client',	// free poker, etc.
		'Teh Forest Lobster',	// brute force tool
		'Turing Machine',	// www.anonymizer.com abuse
		'Ubuntu/9.25',		// comment spam bot
		'unspecified.mail',	// stealth harvesters
		'User-agent: ',		// spam harvester/splogger
		'WebaltBot',		// spam harvester
		'WISEbot',		// spam harvester
		'WISEnutbot',		// spam harvester
		'Win95',		// too old; assumed robot
		'Win98',		// too old; assumed robot
		'WinME',		// too old; assumed robot
		'Win 9x 4.90',		// too old; assumed robot
		'Windows 3',		// too old; assumed robot
		'Windows 95',		// too old; assumed robot
		'Windows 98',		// too old; assumed robot
		'Windows NT 4',		// too old; assumed robot
		'Windows NT;',		// too old; assumed robot
		#'Windows NT 4.0;)',	// wikispam bot
		'Windows NT 5.0;)',	// wikispam bot
		'Windows NT 5.1;)',	// wikispam bot
		'Windows XP 5',		// spam harvester
		'WordPress/4.01',	// pingback spam
		'Xedant Human Emulator',// spammer script engine
		'ZmEu',			// exploit scanner
		'\\\\)',		// spam harvester
	);

	public $ua_regex = array(
		"/^[A-Z]{10}$/",	// misc email spam
// msnbot is using this fake user agent string now
//		"/^Mozilla...[05]$/i",	// fake user agent/email spam
		"/[bcdfghjklmnpqrstvwxz ]{8,}/",
//		"/(;\){1,2}$/",		// misc spammers/harvesters
//		"/MSIE.*Windows XP/",	// misc comment spam
		"/MSIE [2345]/",	// too old; assumed robot
	);

	public $url_strings = array(
		"0x31303235343830303536",	// Havij
		"../",				// path traversal
		"..\\",				// path traversal
		"%60information_schema%60",	// SQL injection probe
		"+%2F*%21",			// SQL injection probe
		"%27--",			// SQL injection
		"%27 --",			// SQL injection
		"%27%23",			// SQL injection
		"%27 %23",			// SQL injection
		"benchmark%28",			// SQL injection probe
		"insert+into+",			// SQL injection
		"r3dm0v3",			// SQL injection probe
		"select+1+from",		// SQL injection probe
		"union+all+select",		// SQL injection probe
		"union+select",			// SQL injection probe
		"waitfor+delay+",		// SQL injection probe
		"w00tw00t",			// vulnerability scanner
	);

	public function isSpambot(RequestInterface $request)
	{
		return $this->checkUri($request->getRequestUri()) || $this->checkUserAgent($request->getUserAgent());
	}

	public function checkUserAgent($agent)
	{
		foreach ($this->ua_start_strings as $string) {
			$pos = strpos($agent, $string);
			if ($pos !== false && $pos == 0) {
				return true;
			}
		}

		foreach ($this->anywhere_ua_strings as $string) {
			if (strpos($agent, $string) !== false) {
				return true;
			}
		}

		foreach ($this->ua_regex as $regex) {
			if (preg_match($regex, $agent)) {
				return true;
			}
		}

		return false;
	}

	public function checkUri($uri)
	{
		foreach ($this->url_strings as $string) {
			if (stripos($uri, $string) !== false) {
				return true;
			}
		}

		return false;
	}
}