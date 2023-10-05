<?php

namespace Tests\Feature;

use App\Models\Question;
use Tests\TestCase;

class QuestionTest extends TestCase
{


    /**
     * A basic feature test example.
     */
    public function test_questions_returned_successfully_with_200(): void
    {

        Question::create([
            "body" => "ؤخىىستيىي يتيىيا يعﻻي يعﻻي يعيﻻ ؟",
            "is_approved" => 0,
            "is_Anonymous" => 1,
            "user_id" => 1,
        ]);
        $response = $this->get('/api/question/show');

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    "id",
                    "body",
                    "is_approved",
                    "is_Anonymous",
                    "user_id",
                    "created_at",
                    "updated_at",
                    "user" => [
                        "id",
                        "name",
                        "email",
                        "gender",
                        "role",
                        "created_at",
                        "updated_at"
                    ]
                ]);
    }
}
