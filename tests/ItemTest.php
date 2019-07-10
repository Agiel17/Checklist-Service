<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShouldGetListItem()
    {
        // $checklist = factory(Checklist::class, 2)->create();

        $response = $this->json('GET', route('checklist.index', ['checklist_id', 1]));
        $response->assertResponseStatus(200);
    } 
}
