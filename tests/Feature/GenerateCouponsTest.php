<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GenerateCouponsTest extends TestCase
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

    /** @test */
    public function only_admin_can_submit_a_coupon()
    {
    	$this->post('/admin/coupons')
    		->assertRedirect('/');

    }

    public function it_records_a_new_coupon_in_the_database()
    {
    	$this->singIn();

    }

    public function it_sends_a_email_to_user_with_coupon_code()
    {
    	
    }
}
