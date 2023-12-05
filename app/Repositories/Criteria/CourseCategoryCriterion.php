<?php

namespace App\Repositories\Criteria;

use App\Queries\CourseListQuery;
use Illuminate\Database\Query\Builder;

class CourseCategoryCriterion implements CourseListCriterion
{
    private CourseListQuery $courseListQuery;

    /**
     * CourseCategoryCriterion constructor.
     */
    public function __construct(CourseListQuery $courseListQuery)
    {
        $this->courseListQuery = $courseListQuery;
    }

    public function shouldApplyToList(): bool
    {
        return $this->courseListQuery->getCategoryIds() !== null;
    }

    public function applyToListBuilder(Builder $query): Builder
    {
        return $query->whereIn('courses.category_id', $this->courseListQuery->getCategoryIds());
    }
}