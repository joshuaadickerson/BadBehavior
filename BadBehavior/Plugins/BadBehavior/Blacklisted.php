<?php

namespace BadBehavior\Plugins\BadBehavior;

use BadBehavior\RequestInterface;
use BadBehavior\Response;

class Blacklisted
{
	/**
	 * Log that this request is blacklisted
	 * @param RequestInterface $request
	 */
	public function log(RequestInterface $request, Response $response)
	{

	}

	/**
	 * Run garbage collection
	 * @param RequestInterface $request
	 */
	public function gc(RequestInterface $request, Response $response)
	{

	}

	/**
	 * Display the error when a user is blacklisted
	 * @param RequestInterface $request
	 */
	public function display(RequestInterface $request, Response $response)
	{
		if ($key == "e87553e1") {
			// FIXME: lookup the real key
		}
		// Create support key
		$ip = explode(".", $request->getIp());
		$ip_hex = "";
		foreach ($ip as $octet) {
			$ip_hex .= str_pad(dechex($octet), 2, 0, STR_PAD_LEFT);
		}
		$support_key = implode("-", str_split("$ip_hex$key", 4));

		// Get response data
		$response = bb2_get_response($previous_key);
		header("HTTP/1.1 " . $response['response'] . " Bad Behavior");
		header("Status: " . $response['response'] . " Bad Behavior");
		$request_uri = $_SERVER["REQUEST_URI"];
		if (!$request_uri) $request_uri = $_SERVER['SCRIPT_NAME'];	# IIS
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<!--< html xmlns="http://www.w3.org/1999/xhtml">-->
		<head>
			<title>HTTP Error <?php echo $response['response']; ?></title>
		</head>
		<body>
	<h1>Error <?php echo $response['response']; ?></h1>
	<p>We're sorry, but we could not fulfill your request for
		<?php echo htmlspecialchars($request_uri) ?> on this server.</p>
	<p><?php echo $response['explanation']; ?></p>
	<p>Your technical support key is: <strong><?php echo $support_key; ?></strong></p>
	<p>You can use this key to <a href="http://www.ioerror.us/bb2-support-key?key=<?php echo $support_key; ?>">fix this problem yourself</a>.</p>
	<p>If you are unable to fix the problem yourself, please contact <a href="mailto:<?php echo htmlspecialchars(str_replace("@", "+nospam@nospam.", bb2_email())); ?>"><?php echo htmlspecialchars(str_replace("@", " at ", bb2_email())); ?></a> and be sure to provide the technical support key shown above.</p>
		<?php
	}
}