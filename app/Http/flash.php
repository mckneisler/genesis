<?php
namespace App\Http;

class flash {
	private function create($title, $message, $level, $key = 'flash_message')
	{
		session()->flash($key, [
			'title' => $title,
			'message' => $message,
			'level' => $level
		]);
	}

	public function info($title, $message)
	{
		$this->create($title, $message, 'info');
	}

	public function success($title, $message)
	{
		$this->create($title, $message, 'success');
	}

	public function error($title, $message)
	{
		$this->create($title, $message, 'error');
	}

	public function overlay($title, $message, $level = 'info')
	{
		$this->create($title, $message, $level, 'flash_message_overlay');
	}

	public function embed($title, $message, $level = 'info')
	{
		$this->create($title, $message, $level, 'flash_message_embed');
	}
}
