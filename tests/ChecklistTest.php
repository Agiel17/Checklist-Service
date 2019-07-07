<?php

use Faker\Factory;
use App\Checklist;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\WithoutMiddleware;

class ChecklistTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShouldCreateChecklist()
    {
        $faker = Factory::create();

        $data = [
            'data' => [
                'attributes' => [
                    'object_domain' => $faker->word,
                    'object_id' => $faker->randomDigitNotNull,
                    'due' => $faker->iso8601($max = 'now'),
                    'urgency' => $faker->randomDigit,
                    'description' => $faker->sentence(5),
                    'items' => [ $faker->sentence(4), $faker->sentence(4), $faker->sentence(4) ],
                    'task_id' => $faker->randomDigitNotNull,        
                ]
            ]
        ];
        
        $structure = [
            "data" => [
              "type",
              "id",
              "attributes" => [
                "object_domain",
                "object_id",
                "task_id",
                "description" ,
                "is_completed" ,
                "due" ,
                "urgency" ,
                "completed_at" ,
                "updated_by" ,
                "created_by" ,
                "created_at" ,
                "updated_at"
              ],
              "links" => [
                "self"
              ]
            ]
        ];

        $response = $this->json('POST', route('checklist.store'), $data);
        $response->assertResponseStatus(201);
        $response->seeJsonStructure($structure);
    }

    public function testShouldGetListChecklist()
    {
        $checklist = factory(Checklist::class, 2)->create();

        $response = $this->json('GET', route('checklist.index'));
        $response->assertResponseStatus(200);
    }    

    public function testShouldGetChecklist()
    {
        $checklist = factory(Checklist::class)->create();

        $structure = [
            "data" => [
              "type",
              "id",
              "attributes" => [
                "object_domain",
                "object_id",
                "task_id",
                "description" ,
                "is_completed" ,
                "due" ,
                "urgency" ,
                "completed_at" ,
                "updated_by" ,
                "created_by" ,
                "created_at" ,
                "updated_at"
              ],
              "links" => [
                "self"
              ]
            ]
        ];

        $response = $this->json('GET', route('checklist.show',['checklist_id' => $checklist->checklist_id]));
        $response->assertResponseStatus(200);
        $response->seeJsonStructure($structure);
    }    

    public function testShouldDeleteChecklist()
    {
        $checklist = factory(Checklist::class)->create();

        $response = $this->json('DELETE', route('checklist.destroy',['checklist_id' => $checklist->checklist_id]));
        $response->assertResponseStatus(204);
    }     
}
