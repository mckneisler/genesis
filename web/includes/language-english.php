<?php
$i = 1;
$language['menu'][$i]['id'] = 'music';
$language['menu'][$i]['text'] = 'Music';
$language['menu'][$i]['title'] = 'Display music information';
$language['menu'][$i]['url'] = 'artists.php';

	$j = 1;
	$language['menu'][$i]['submenu'][$j]['id'] = 'artists';
	$language['menu'][$i]['submenu'][$j]['text'] = 'Artists';
	$language['menu'][$i]['submenu'][$j]['title'] = 'Display a List of Artists';
	$language['menu'][$i]['submenu'][$j]['url'] = 'artists.php';

	$j++;
	$language['menu'][$i]['submenu'][$j]['id'] = 'albums';
	$language['menu'][$i]['submenu'][$j]['text'] = 'Albums';
	$language['menu'][$i]['submenu'][$j]['title'] = 'Display a List of Albums';
	$language['menu'][$i]['submenu'][$j]['url'] = 'albums.php';

	$j++;
	$language['menu'][$i]['submenu'][$j]['id'] = 'songs';
	$language['menu'][$i]['submenu'][$j]['text'] = 'Songs';
	$language['menu'][$i]['submenu'][$j]['title'] = 'Display a List of Songs';
	$language['menu'][$i]['submenu'][$j]['url'] = 'songs.php';

if ($_SESSION['isLoggedIn']) {
	$i++;
	$language['menu'][$i]['id'] = 'logout';
	$language['menu'][$i]['text'] = 'Logout';
	$language['menu'][$i]['title'] = 'Logout of ' . $appName . ' Application';
	$language['menu'][$i]['url'] = 'index.php?logout=true';
} else {
	if ($menuSelected == "register") {
		$i++;
		$language['menu'][$i]['id'] = 'register';
		$language['menu'][$i]['text'] = 'Register';
		$language['menu'][$i]['title'] = 'Create a New User Profile';
		$language['menu'][$i]['url'] = 'register.php';
	} else {
		$i++;
		$language['menu'][$i]['id'] = 'login';
		$language['menu'][$i]['text'] = 'Login';
		$language['menu'][$i]['title'] = 'Login to the Recordly Application';
		$language['menu'][$i]['url'] = 'login.php';
	}
}

$language['heading']['fatalError'] = 'Fatal Error';
$language['heading']['login'] = 'Login';
$language['heading']['page'] = 'Music Management System';
$language['heading']['newUser'] = 'New User Registration';
$language['heading']['title'] = $appName . ' Music Management System';

$language['label']['action'] = 'Action';
$language['label']['album'] = 'Album';
$language['label']['albums'] = 'Albums';
$language['label']['artist'] = 'Artist';
$language['label']['email'] = 'Email';
$language['label']['favorite'] = 'Favorite';
$language['label']['password'] = 'Password';
$language['label']['reenterPassword'] = 'Re-enter Password';
$language['label']['song'] = 'Song';
$language['label']['songs'] = 'Songs';

$language['button']['login'] = 'Login';
$language['button']['register'] = 'Register';

$language['message']['emailAE'] = 'Email address already exists';
$language['message']['emailNotReg'] = 'Email address has not been registered';
$language['message']['errorsFound'] = 'Errors were found on this page in the fields identified below:';
$language['message']['doesNotMatch'] = 'Does not match password above';
$language['message']['incorrectPassword'] = 'Password is not correct for this email';
$language['message']['invalidPassword'] = 'Invalid password format, it must';
$language['message']['noRecords'] = 'No records were found';
$language['message']['requiredField'] = 'This is a required field';

$language['phrase']['added'] = 'Added';
$language['phrase']['atLeast1Lower'] = ' contain at least 1 lowercase';
$language['phrase']['atLeast1Num'] = ' contain at least 1 number';
$language['phrase']['atLeast1Spec'] = ' contain at least 1 special (!@#$%^&*-_)';
$language['phrase']['atLeast1Upper'] = ' contain at least 1 uppercase';
$language['phrase']['deleted'] = 'Deleted';
$language['phrase']['emailSubject'] = 'Questions from Website';
$language['phrase']['existingUser'] = 'Existing User?';
$language['phrase']['greaterThan8Char'] = ' be greater than 8 characters';
$language['phrase']['lessThan20Char'] = ' be less than 20 characters';
$language['phrase']['loggedIn'] = 'logged in';
$language['phrase']['login'] = 'Login to your account';
$language['phrase']['newUser'] = 'New User?';
$language['phrase']['passwordRules'] = '(8-20 chars, 1 number, 1 upper, 1 lower and 1 special)';
$language['phrase']['pleaseLogin'] = 'Please login or register using the options above.';
$language['phrase']['questions'] = 'Questions? Email';
$language['phrase']['removed'] = 'Removed';
$language['phrase']['returnToHome'] = 'Return to home page.';
$language['phrase']['siteDesc'] = 'With ' . $appName . ' you can search musical artists and their albums and songs. You can also identify your favorites of each.';
$language['phrase']['signUp'] = 'Sign up for a new account';
$language['phrase']['swipe'] = 'SWIPE';
$language['phrase']['webmaster'] = $appName . ' Webmaster';
$language['phrase']['toSelectFavs'] = 'To select your favorites, you must first be';
?>
