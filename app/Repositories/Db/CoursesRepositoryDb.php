<?php

namespace App\Repositories\Db;

use App\Repositories\CoursersRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CoursesRepositoryDb implements CoursersRepository
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
     * @return \Illuminate\Database\Query\Builder
     */
    private function getBuilder(int $limit): \Illuminate\Database\Query\Builder
    {
        return DB::table('courses')
            ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
            ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
            ->where('courses.is_active', true)
            ->limit($limit);
    }
}