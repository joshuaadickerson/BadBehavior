<?php

namespace BadBehavior\SpamHaus;

final class ResultCodes
{
	// http://www.spamhaus.org/faq/section/DNSBL%20Usage#366
	const SBL_DATA                  = '127.0.0.2';
	const SBC_CSS_DATA              = '127.0.0.3';
	const CBL_DATA                  = '127.0.0.4';
	const ISP_MAINTAINED            = '127.0.0.10';
	const SPAMHAUS_MAINTAINED       = '127.0.0.11';

	// http://www.spamhaus.org/faq/section/Spamhaus%20DBL#291
	const SPAM_DOMAIN               = '127.0.1.2';
	const PHISH_DOMAIN              = '127.0.1.4';
	const MALWARE_DOMAIN            = '127.0.1.5';
	const BOTNET_DOMAIN             = '127.0.1.6';
	const ABUSED_LEGIT_SPAM         = '127.0.1.102';
	const REDIRECTOR_DOMAIN         = '127.0.1.103';
	const ABUSED_LEGIT_PHISH        = '127.0.1.104';
	const ABUSED_LEGIT_MALWARE      = '127.0.1.105';
	const ABUSED_LEGIT_BOTNET       = '127.0.1.106';
	const IP_QUERIES_PROHIBITED     = '127.0.1.255';
}