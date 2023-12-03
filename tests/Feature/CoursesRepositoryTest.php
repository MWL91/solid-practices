<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\InstructionLevel;
use App\Models\Instructor;
use App\Models\User;
use App\Repositories\Db\CoursesRepositoryDb;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Factories\CreateCourses;
use Tests\TestCase;

class CoursesRepositoryTest extends TestCase
{
    use WithFaker, RefreshDatabase, CreateCourses;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItShouldCreateAndFetchCourses(): void
    {
        // Given:
        $course = $this->createCourse();
        $repository = app(CoursesRepositoryDb::class);

        // When:
        $latest = $repository->getLatestCourses(1);
        $free = $repository->getFreeCourses(1);
        $discounted = $repository->getDiscountCourses(1);


        // Then:
        $this->assertEquals($course->getKey(), $latest->first()->id);
        $this->assertEquals($course->getKey(), $free->first()->id);
        $this->assertEquals($course->getKey(), $discounted->first()->id);

        $this->assertValidStructureOfCourse($latest->first());
        $this->assertValidStructureOfCourse($free->first());
        $this->assertValidStructureOfCourse($discounted->first());

        $this->assertCount(1, $latest);
        $this->assertCount(1, $free);
        $this->assertCount(1, $discounted);
    }

    /**
     * @param $latest
     * @return void
     */
    private function assertValidStructureOfCourse(\stdClass $latest): void
    {
        $this->assertArrayHasKey('id', (array)$latest);
        $this->assertArrayHasKey('instructor_id', (array)$latest);
        $this->assertArrayHasKey('category_id', (array)$latest);
        $this->assertArrayHasKey('instruction_level_id', (array)$latest);
        $this->assertArrayHasKey('course_title', (array)$latest);
        $this->assertArrayHasKey('course_slug', (array)$latest);
        $this->assertArrayHasKey('keywords', (array)$latest);
        $this->assertArrayHasKey('overview', (array)$latest);
        $this->assertArrayHasKey('course_image', (array)$latest);
        $this->assertArrayHasKey('thumb_image', (array)$latest);
        $this->assertArrayHasKey('course_video', (array)$latest);
        $this->assertArrayHasKey('duration', (array)$latest);
        $this->assertArrayHasKey('price', (array)$latest);
        $this->assertArrayHasKey('strike_out_price', (array)$latest);
        $this->assertArrayHasKey('is_active', (array)$latest);
        $this->assertArrayHasKey('created_at', (array)$latest);
        $this->assertArrayHasKey('updated_at', (array)$latest);
        $this->assertArrayHasKey('first_name', (array)$latest);
        $this->assertArrayHasKey('last_name', (array)$latest);
    }
}
