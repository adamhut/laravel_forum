<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspection\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpamTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test*/
    public function it_checks_for_invalid_keywords()
    {
    	//invalid keywords

    	$spam = new Spam();

    	$this->assertFalse($spam->detect('Innocent reply here'));

    	$this->expectException('Exception');
    	$spam->detect('yahoo customer support');

    }

    /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
    	$spam = new Spam();

    	$this->expectException('Exception');
    	$spam->detect('hello world aaaaaaaaaaaaa');

    }

}
