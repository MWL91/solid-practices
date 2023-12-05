<?php

namespace App\Repositories\QueryHandlers;

use App\Queries\CourseListQuery;
use App\Repositories\Criteria\CourseCategoryCriterion;
use App\Repositories\Criteria\InstructionLevelCriterion;
use App\Repositories\Criteria\PriceCriterion;
use App\Repositories\Criteria\SortCriterion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CourseListQueryDbHandler implements CourseListQueryHandler
{
    private function builder(CourseListQuery $courseListQuery): Builder
    {
        $query = $this->getBuilder();

        $criteria = [
            new CourseCategoryCriterion($courseListQuery),
            new InstructionLevelCriterion($courseListQuery),
            new PriceCriterion($courseListQuery),
            new SortCriterion($courseListQuery)
        ];

        foreach($criteria as $criterion) {
            if($criterion->shouldApplyToList()) {
                $criterion->applyToListBuilder($query);
            }
        }

        return $query->groupBy('courses.id');
    }

    public function paginate(CourseListQuery $courseListQuery): LengthAwarePaginator
    {
        return $this->builder($courseListQuery)->paginate($courseListQuery->getPaginateCount());
    }

    public function handle(CourseListQuery $courseListQuery): Collection
    {
        return $this->builder($courseListQuery)->get();
    }

    private function getBuilder(): Builder
    {
        return DB::table('courses')
            ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
            ->selectRaw('AVG(course_ratings.rating) AS average_rating')
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
            ->where('courses.is_active', true);
    }

}