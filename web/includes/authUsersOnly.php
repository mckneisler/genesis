<?php

// This file prevents unauthenticated users from entering the system.
// They are redirected to the login page.

if (!isset($_SESSION['userInfo'])) {
	setGeneralError('You must first login to access the resource requested.');
	redirect($urlRoot . 'login.php');
}

?>
