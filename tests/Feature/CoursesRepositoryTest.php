<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseRating;
use App\Models\InstructionLevel;
use App\Models\Instructor;
use App\Models\User;
use App\Repositories\CoursersRepository;
use App\Repositories\Db\CoursesRepositoryDb;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursesRepositoryTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // Given:
        $user = User::create([
            'name'=>$this->faker->name(),
            'email'=>$this->faker->email(),
            'password'=>$this->faker->password(),
            'is_active'=> true
        ]);

        $category = Category::create([
            'name'=>$this->faker->name(),
            'slug'=>$this->faker->slug(),
//            'icon_class'=>
            'is_active'=> true
        ]);

        $instructor = Instructor::create([
            'user_id' => $user->getKey(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'instructor_slug' => $this->faker->slug(),
            'contact_email' => $this->faker->email(),
            'telephone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
//            'paypal_id' => ,
//            'link_facebook' => ,
//            'link_linkedin' => ,
//            'link_twitter' => ,
//            'link_googleplus' => ,
            'biography' => $this->faker->paragraph(),
//            'instructor_image' => ,
//            'total_credits' => ,
        ]);

        $instruction_level = InstructionLevel::create([
            'level'=>1,
        ]);

        $course = Course::create([
            'instructor_id' => $instructor->getKey(),
            'category_id' => $category->getKey(),
            'instruction_level_id' => $instruction_level->getKey(),
            'course_title' => $this->faker->name(),
            'course_slug' => $this->faker->slug(),
            'keywords' => '',
            'overview' => '',
            'course_image' => '',
            'thumb_image' => '',
            'course_video' => '',
            'duration' => '',
            'price' => 0,
            'strike_out_price' => 100,
            'is_active' => 1,
        ]);

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
