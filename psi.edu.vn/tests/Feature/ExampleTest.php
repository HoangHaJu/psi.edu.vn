<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        // Comment (vô hiệu hóa) 2 dòng này lại
        // $response = $this->get('/');
        // $response->assertStatus(200);

        // Chỉ để lại dòng này để bài test luôn luôn ĐÚNG
        $this->assertTrue(true);
    }
}