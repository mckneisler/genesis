<?php
/**
 * Steps through items or arrays in an array and applies mysql_real_escape_array().
 * Precondition: a connection to the database
 * @param mixed $array
 * @return mixed $array
 */
function notifyWebAdmin($error) {
    $subject = "WebAdmin Error Notification";
    if (defined('$urlRoot')) {
      $subject .= " from " . $urlRoot;
    }
    $message  = "The following error occurred:\n";
    $message .= "\t$error\n";
    sendEmail(TEST_EMAIL, $subject, $message, NULL, NULL);
}

/**
 * Send email message
 */
function sendEmail($to, $subject, $message, $headers, $from) {
	if (!empty($from)) {
		$headers  .= "From: ".$from."\n";
	} elseif (defined('ADMIN_EMAIL')) {
		$headers  .= "From: ".ADMIN_EMAIL."\n";
	}

	if (is_array($to)) {
		foreach ($to as $email) {
			if (preg_match("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$^", $email)) {
				if (defined('TEST_EMAIL')) {
					$testMessage  = $message;
					$testMessage .= "\n\n";
					$testMessage .= "*** Email system is in test mode. ***\n";
					$testMessage .= "This message would have been sent to $email\n";
					$testMessage .= "Generated from host '".$_SERVER['SERVER_NAME']."'\n";
					mail(TEST_EMAIL, $subject, $testMessage, $headers);
				} else {
					mail($email, $subject, $message, $headers);
				}
			}
		}
	} else {
		if (preg_match("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$^", $to)) {
			if (defined('TEST_EMAIL')) {
				$testMessage  = $message;
				$testMessage .= "\n\n";
				$testMessage .= "*** Email system is in test mode. ***\n";
				$testMessage .= "This message would have been sent to $to\n";
				$testMessage .= "Generated from host '".$_SERVER['SERVER_NAME']."'\n";
				mail(TEST_EMAIL, $subject, $testMessage, $headers);
			} else {
				mail($to, $subject, $message, $headers);
			}
		}
	}
}

?>
