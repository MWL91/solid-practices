<?php

namespace App\Repositories\Db;

use App\Repositories\CourseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CoursesRepositoryDb implements CourseRepository
{
    public function getLatestCourses(int $limit): Collection
    {
        return $this->getBuilder($limit)
            ->orderBy('courses.updated_at', 'desc')
            ->get();
    }

    public function getFreeCourses(int $limit): Collection
    {
        return $this->getBuilder($limit)
            ->where('courses.price', 0)
            ->get();
    }

    public function getDiscountCourses(int $limit): Collection
    {
        return $this->getBuilder($limit)
            ->where('courses.strike_out_price', '<>' ,null)
            ->get();
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
}