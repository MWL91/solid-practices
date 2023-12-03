<?php

namespace App\ValueObjects;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;

final class Course implements Arrayable
{
    private int $id;

    private InstructorName $instructor;
    private int $category_id;
    private int $instruction_level_id;
    private string $course_title;
    private string $course_slug;
    private string $keywords;
    private string $overview;
    private string $course_image;
    private string $thumb_image;
    private ?int $course_video;
    private string $duration;
    private float $price;
    private float $strike_out_price;
    private ?bool $is_active;
    private CarbonInterface $created_at;
    private CarbonInterface $updated_at;

    public function __construct(int $id, string $instructor_first_name, string $instructor_last_name, int $instructor_id, int $category_id, int $instruction_level_id, string $course_title, string $course_slug, string $keywords, string $overview, string $course_image, string $thumb_image, ?int $course_video, string $duration, float $price, float $strike_out_price, ?bool $is_active, CarbonInterface $created_at, CarbonInterface $updated_at)
    {
        $this->id = $id;
        $this->instructor = new InstructorName($instructor_id, $instructor_first_name, $instructor_last_name);
        $this->category_id = $category_id;
        $this->instruction_level_id = $instruction_level_id;
        $this->course_title = $course_title;
        $this->course_slug = $course_slug;
        $this->keywords = $keywords;
        $this->overview = $overview;
        $this->course_image = $course_image;
        $this->thumb_image = $thumb_image;
        $this->course_video = $course_video;
        $this->duration = $duration;
        $this->price = $price;
        $this->strike_out_price = $strike_out_price;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'instructor_first_name' => $this->instructor_first_name,
            'instructor_last_name' => $this->instructor_last_name,
            'instructor_id' => $this->instructor_id,
            'category_id' => $this->category_id,
            'instruction_level_id' => $this->instruction_level_id,
            'course_title' => $this->course_title,
            'course_slug' => $this->course_slug,
            'keywords' => $this->keywords,
            'overview' => $this->overview,
            'course_image' => $this->course_image,
            'thumb_image' => $this->thumb_image,
            'course_video' => $this->course_video,
            'duration' => $this->duration,
            'price' => $this->price,
            'strike_out_price' => $this->strike_out_price,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInstructorFirstName(): string
    {
        return $this->instructor->getFirstName();
    }

    public function getInstructorLastName(): string
    {
        return $this->instructor->getLastName();
    }

    public function getInstructorName(): string
    {
        return $this->instructor->getFullName();
    }

    public function getInstructorId(): int
    {
        return $this->instructor_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getInstructionLevelId(): int
    {
        return $this->instruction_level_id;
    }

    public function getCourseTitle(): string
    {
        return $this->course_title;
    }

    public function getCourseSlug(): string
    {
        return $this->course_slug;
    }

    public function getKeywords(): string
    {
        return $this->keywords;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getCourseImage(): string
    {
        return $this->course_image;
    }

    public function getThumbImage(): string
    {
        return $this->thumb_image;
    }

    public function getCourseVideo(): ?int
    {
        return $this->course_video;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStrikeOutPrice(): float
    {
        return $this->strike_out_price;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function getCreatedAt(): CarbonInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): CarbonInterface
    {
        return $this->updated_at;
    }

//    public function __get(string $value)
//    {
//        $keys = [
//            'first_name' => 'instructor_first_name',
//            'last_name' => 'instructor_last_name',
//        ];
//
//        if(isset($keys[$value])) {
//            $value = $keys[$value];
//        }
//
//        return $this->$value;
//    }
}