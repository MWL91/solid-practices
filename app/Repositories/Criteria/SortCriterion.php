<?php

namespace App\Repositories\Criteria;

use App\Queries\CourseListQuery;
use Illuminate\Database\Query\Builder;

class SortCriterion implements CourseListCriterion
{
    private CourseListQuery $courseListQuery;

    /**
     * SortCriterion constructor.
     */
    public function __construct(CourseListQuery $courseListQuery)
    {
        $this->courseListQuery = $courseListQuery;
    }

    public function shouldApplyToList(): bool
    {
        return true;
    }

    public function applyToListBuilder(Builder $query): Builder
    {
        return $query->orderBy('courses.price', $this->courseListQuery->getSort());
    }
}