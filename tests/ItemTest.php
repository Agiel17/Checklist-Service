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
    public function testShouldCreateItem()
    {
        // $factory = Factory::create();

        // $response = $this->json('POST', '/checklist/{checklist_id}/items');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}
