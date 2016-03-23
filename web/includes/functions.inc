<?php
/**
 * Basic debugging function. Displays passed var. If no value is specified for a
 * second argument, the program exits.
 *
 * @param mixed $var
 * @param mixed $noexit
 */
function _dump($var, $noexit = '') {
	echo "\n<pre>\n";
	print_r($var);
	echo "\n</pre>";
	if(empty($noexit)) {
		exit();
	}
}

/**
 * Returns a sorted array of arrays
 *
 * Multiple arguments may be passed into the function after the array.  These will be treated at the
 * associative indexes into the arrays to be used to determine the multiple sort key.
 *
 * @params array $array
 * @params string arg[1], arg[2], arg[3] ... arg[n]
 * @return array
 */
function arraySort($array) {
	$argCount = func_num_args() - 1;
	$args = func_get_args();
	unset($args[0]);

	while (list($key, $value) = each($array)) {
		$sortKey = '';
		for ($argIndex = 1; $argIndex <= $argCount; $argIndex++) {
			$sortKey .= $array[$key][$args[$argIndex]];
		}
		$sortKeys[$key] = $sortKey;
	}

	asort($sortKeys);
	reset($sortKeys);
	while (list($key, $value) = each($sortKeys)) {
		$sortedArray[$key] = $array[$key];
	}

	return $sortedArray;
}

/**
 * Returns the string replacing all breaks with newlines.
 * This is the reverse of the PHP function "nl2br".
 *
 * @params string $text
 * @return string
 */
function br2nl($text) {
	return  preg_replace('/<br\\\\s*?\\/??>/i', "\\n", $text);
}

function dv($data) {
	echo nl2br(str_replace(' ', '&nbsp;', print_r($data, true))) . '<hr>';
}

function generatePassword($length=8) {
	return substr(md5(rand(1, 1000000)), 0, $length);
}

/**
 * This function this function prepares the $_POST variable for extraction.
 * It takes as input the $_POST array, and an array of variable that are
 * safe to remove from the $_POST.
 *
 * @param array $post
 * @param array $variables
 * @return array $extractedPost
 */
function postExtract($post, $variables) {
	foreach ($variables as $key => $variable) {
		if (is_array($variable)) {
			if (count($variable) == 0) {
				while (list($subKey, $subValue) = each($post[$key])) {
					$extractedPost[$key][$subKey] = $subValue;
				}
			} else {
				$extractedPost[$key] = postExtract($post[$key], $variable);
			}
		} else {
			if (isset($post[$variable])) {
				$extractedPost[$variable] =  trim($post[$variable]);
			}
		}
	}
	$extractedPost = mysql_real_escape_array($extractedPost);
	return $extractedPost;
}


/**
 * This is just a simple redirect function
 * but it makes sure that the session is written
 * and closed before the redirect happens
 *
 * @param string $url URL to redirect to
 */
function redirect($url = null) {
	if (!preg_match('/^http|https/i',$url)) {
		$url = "http://" . $_SERVER['HTTP_HOST'] . $url;
	}
	session_write_close();
	header('Location: '.$url);
	exit;
}

/**
 * Checks whether a var is empty. If so, it unsets it. If passed an array,
 * it'll check each element in the array and unset any elements that
 * evaluate as empty. Note that the var is passed by reference.
 *
 * @param mixed $arg
 */
function unsetEmptyVars (&$arg) {
	if (is_array($arg)) {
		foreach ($arg as $key => $value) {
			$value = trim($value);
			if(empty($value)) {
				unset($arg[$key]);
			}
		}
	} else {
		trim($arg);
		if(empty($arg)) {
			unset($arg);
		}
	}
}


/**
 * Validates login credentials and puts three arrays into the session:
 *  userInfo, libraryInfo, grants
 *
 * @param string $userName
 * @param string $userPass
 * @return int
 */
function processLogin($userName, $userPass) {
	$_SESSION['isLoggedIn'] = FALSE;

	$userId = validatePassword($userName, $userPass);
	if ($userId !== FALSE) {
		$userInfo['userId'] = $userId;
		$isLoggedIn = TRUE;
		$_SESSION['isLoggedIn'] = TRUE;
		$_SESSION['userInfo'] = $userInfo;
	}

	return $isLoggedIn;
}

function validatePassword($userName, $userPass) {
	// usernames are case-insensitve
	$userName = strtolower($userName);
	$userName = mysql_real_escape_string($userName);

	// encrypt the password
	$userPass = md5($userPass);
	$userPass = mysql_real_escape_string($userPass);

	$sql  = "SELECT userId ";
	$sql .= "FROM users ";
	$sql .= "WHERE emailTxt = '$userName' ";
	$sql .= "  AND passwordTxt = '$userPass'";
	$oDB = new genesis\db;
	$result = $oDB->query($sql);

	if (mysql_num_rows($result) == 1) {
		list($userId) = mysql_fetch_row($result);
		return $userId;
	} else {
		return FALSE;
	}
}

?>
