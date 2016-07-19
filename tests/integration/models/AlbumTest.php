<?php

use App\Artist;

class AlbumTest extends PHPUnit_Framework_TestCase
{
	protected $album;

	public function setUp()
	{
		$this->artist = new Artist(['name' => 'Prince']);
	}

	/** @test */
	function an_artist_has_a_name()
	{

		$this->assertEquals('Prince', $this->artist->name);
	}
}
