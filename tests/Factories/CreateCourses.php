<?php

namespace Tests\Factories;

use App\Models\Category;
use App\Models\Course;
use App\Models\InstructionLevel;
use App\Models\Instructor;
use App\Models\User;

trait CreateCourses
{
    public function createCourse(): Course
    {
        $user = User::create([
            'name'=>$this->faker->name(),
            'email'=>$this->faker->email(),
            'password'=>$this->faker->password(),
            'is_active'=> true
        ]);

        $category = Category::create([
            'name'=>$this->faker->name(),
            'slug'=>$this->faker->slug(),
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
            'biography' => $this->faker->paragraph(),
        ]);

        $instruction_level = InstructionLevel::create([
            'level'=>1,
        ]);

        return Course::create([
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
    }
}