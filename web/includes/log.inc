<?php
/**
 * This function simply generates an entry in the logfile. The location
 * for the logfile is defined in setEnv.php
 */
function myLog($entry) {
  error_log(strftime("------------------------------------ [%D %T] ------------------------------------\n$entry\n\n"), 3, ERROR_FILE);
}

?>