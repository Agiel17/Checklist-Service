<?php

use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShouldCreateUser()
    {
        $user = factory('App\User')->create();

        $this->assertTrue(true);
    }
}
