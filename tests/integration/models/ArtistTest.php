<?php

use App\Artist;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ArtistTest extends TestCase
{
	use DatabaseTransactions;

	protected $artist;

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
