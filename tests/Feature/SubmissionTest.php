<?php

namespace Tests\Feature;

use App\Events\SubmissionSaved;
use App\Jobs\SaveSubmissionJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_validation_is_working(): void
    {
        $response = $this->postJson('/api/submit', [
            'name' => 23,
            'email' => 'john.doeexample.com',
            'message' => 23
        ]);


        $response->assertInvalid(['name', 'email', 'message']);
    }

    public function test_request_is_success(): void
    {
        $response = $this->postJson('/api/submit', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ]);

        $response->assertStatus(200);
    }

    public function test_job_is_dispatching(): void
    {
        Queue::fake();
        $response = $this->postJson('/api/submit', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ]);

        Queue::assertPushed(SaveSubmissionJob::class);

        $response->assertStatus(200);
    }
}
