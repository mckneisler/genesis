<?php

namespace App\Exceptions;

use Exception;

class SystemErrorException extends Exception
{

	public function __construct($message = null, $code = 0, Exception $previous = null)
	{
		if (is_null($message)) {
			$message = 'An unspecified system error has occurred.';
		}
		parent::__construct($message, $code, $previous);
	}

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
