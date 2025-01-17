<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\ClassTypeSeeder;
use App\Models\ClassType;
use App\Models\ScheduledClass;

class InstructorTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_instructor_is_redirected_to_instructor_dashboard() {
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $response = $this->actingAs($user) // login
        ->get('/dashboard');

        $response->assertRedirectToRoute('instructor.dashboard');

        $this->followRedirects($response)->assertSeeText("MyGym");
    }

    public function test_instructor_can_schedule_a_class() {
        //Given
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);
        $this->seed(ClassTypeSeeder::class);

        //When
        $response = $this->actingAs($user)
            ->post('instructor/schedule', [
            'class_type_id' => ClassType::first()->id,
            'date' => '2023-12-29',
            'time' => '15:00:00'
        ]);

        //Then 
        $this->assertDatabaseHas('scheduled_classes',[
            'class_type_id' => ClassType::first()->id,
            'date_time' => '2023-12-29 15:00:00'
        ]);
        $response->assertRedirectToRoute('schedule.index');
    }


    public function test_instructor_can_cancel_class() {
        // Given
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);
        $this->seed(ClassTypeSeeder::class);
        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => '2023-12-29 10:00:00'
        ]);

        // When
        $response = $this->actingAs($user)
            ->delete('/instructor/schedule/'.$scheduledClass->id);

        // Then
        $this->assertDatabaseMissing('scheduled_classes',[
            'id' => $scheduledClass->id
        ]);
    }


    public function test_cannot_cancel_class_less_than_two_hours_before() {
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);
        $this->seed(ClassTypeSeeder::class);
        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => now()->addHours(1)->minutes(0)->seconds(0)
        ]);
        
        $response = $this->actingAs($user)
            ->get('instructor/schedule');

        $response->assertDontSeeText('Cancel');

        $response = $this->actingAs($user)
            ->delete('/instructor/schedule/'.$scheduledClass->id);

        $this->assertDatabaseHas('scheduled_classes',[
            'id' =>$scheduledClass->id
        ]);
    }
}
