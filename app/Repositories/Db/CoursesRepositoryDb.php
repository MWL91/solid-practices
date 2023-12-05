<?php

namespace App\Repositories\Db;

use App\Models\Category;
use App\Models\InstructionLevel;
use App\Queries\CourseListQuery;
use App\Repositories\CourseRepository;
use App\Repositories\QueryHandlers\CourseListQueryHandler;
use App\ValueObjects\Course;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CoursesRepositoryDb implements CourseRepository
{
    private CourseListQueryHandler $courseListQuery;

    public function __construct(CourseListQueryHandler $courseListQuery)
    {
        $this->courseListQuery = $courseListQuery;
    }

    public function getLatestCourses(int $limit): Collection
    {
        return $this->getBuilder($limit)
            ->orderBy('courses.updated_at', 'desc')
            ->get()
            ->map($this->mapToCourse());
    }

    public function getFreeCourses(int $limit): Collection
    {
        return $this->getBuilder($limit)
            ->where('courses.price', 0)
            ->get()
            ->map($this->mapToCourse());
    }

    public function getDiscountCourses(int $limit): Collection
    {
        return $this->getBuilder($limit)
            ->where('courses.strike_out_price', '<>' ,null)
            ->get()
            ->map($this->mapToCourse());
    }

    /**
     * @param int $limit
     * @return Builder
     */
    private function getBuilder(int $limit): Builder
    {
        return DB::table('courses')
            ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
            ->where('courses.is_active', true)
            ->limit($limit);
    }

    private function mapToCourse(): callable
    {
        return fn(\stdClass $data): Course => new Course(
            $data->id,
            $data->first_name,
            $data->last_name,
            $data->instructor_id,
            $data->category_id,
            $data->instruction_level_id,
            $data->course_title,
            $data->course_slug,
            $data->keywords,
            $data->overview,
            $data->course_image,
            $data->thumb_image,
            $data->course_video,
            $data->duration,
            $data->price,
            $data->strike_out_price,
            $data->is_active,
            Carbon::make($data->created_at),
            Carbon::make($data->updated_at)
        );
    }

    public function getCategories(bool $active = true): Collection
    {
        return Category::where('is_active', $active)->get();
    }

    public function getInstructionLevels(): Collection
    {
        return InstructionLevel::get();
    }

    public function getListing(CourseListQuery $courseListQuery): LengthAwarePaginator
    {
        return $this->courseListQuery->paginate($courseListQuery);
    }
}