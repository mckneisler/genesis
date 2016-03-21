<?php
/**
 * Generates the navigation menu appropriate for the currently logged in user
 * and the path of the current page
 *
 * @return array
 */
function getNavigationMenu() {
/*
The array defined below ($menu) holds all the information for
the navigation tabs that appear in the GMS application.

To add a tab, just add an element to the array. Each tab has the
following properties defined in this array:

    title:  The text that appears on the tab itself.
            This text is the clickable link.

    url:    The target of the link; what the tab links to.

*/

	ksort($navMenu);
	return $navMenu;

}


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
 * Performs an insert into the specified table using the fields and values in the
 * input array and returns the inserted id if the table has an auto-assign
 * attribute.
 *
 * @param string $table
 * @param array $data
 * @return int insert_id
 */
function myInsert($table, $data) {
	if (!is_array($data)) {
		return;
	}
	$fields = "";
	$values = "";
	foreach ($data as $key => $val) {
		$fields .= !empty($fields) ? ",`".$key."`" : "`".$key."`";
		$values .= !empty($values)
			? ','.(trim($val) != '' ? "'".mysql_real_escape_string($val)."'" : 'NULL')
			: (trim($val) != '' ? "'".mysql_real_escape_string($val)."'" : 'NULL');
	}
	$sql = "INSERT INTO $table ($fields) VALUES ($values);";
	$result = myQuery($sql);
	if ($result) {
		return mysql_insert_id();
	}

	return FALSE;
}

/**
 * Performs a quest and returns the results object if the query did not generate
 * an error. If an error was generated then the output of mysql_error() is logged
 * and also sent to the fatalError function.
 */
function myQuery($query) {
	$result = mysql_query($query);
	if (!$result) {
		$errorMSG = mysql_error();
		$errorMSG .= "\n\n".preg_replace('/\s+/', ' ', $query);
		fatalError($errorMSG, $reportCallStack=1);
	}
	return $result;
}

/**
* Generic update function, will only update a single row
*
* @param string $table Table to update
* @param array $data Data to update in the table
* @param string $condition Any conditional statements (Where id=3)
*/
function myUpdate($table, $data, $condition = null) {
	foreach ($data as $key => $val) {
		$values .= !empty($values) ? "," : "";
		$values .= '`'.$key.'`='.(trim($val) != '' ? "'".mysql_real_escape_string($val)."'" : "NULL");
	}
	$sql = "UPDATE $table SET $values $condition";
	return myQuery($sql);
}

/**
 * Steps through items or arrays in an array and applies mysql_real_escape_array().
 * Precondition: a connection to the database
 * @param mixed $array
 * @return mixed $array
 */
function mysql_real_escape_array($array) {
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$array[$key] = mysql_real_escape_array($value);
		} else {
			$array[$key] = mysql_real_escape_string($value);
		}
	}
	return $array;
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
	$result = myQuery($sql);

	if (mysql_num_rows($result) == 1) {
		list($userId) = mysql_fetch_row($result);
		return $userId;
	} else {
		return FALSE;
	}
}

?>
