<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InstructionLevel;
use App\Models\Instructor;
use App\Models\User;
use App\Repositories\Db\CoursesRepositoryDb;
use App\ValueObjects\Course;
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
        $this->assertEquals($course->getKey(), $latest->first()->getId());
        $this->assertEquals($course->getKey(), $free->first()->getId());
        $this->assertEquals($course->getKey(), $discounted->first()->getId());

        $this->assertInstanceOf(Course::class, $latest->first());
        $this->assertInstanceOf(Course::class, $free->first());
        $this->assertInstanceOf(Course::class, $discounted->first());

        $this->assertCount(1, $latest);
        $this->assertCount(1, $free);
        $this->assertCount(1, $discounted);
    }
}
