<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Jobs\LoadSongs;

class LoadController extends Controller
{
    public function songs($file)
	{
		$job = new LoadSongs($file);
		$this->dispatch($job);
		return 'Done!';
	}
}
