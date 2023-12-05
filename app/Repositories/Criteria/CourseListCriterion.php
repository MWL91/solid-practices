<?php

namespace App\Repositories\Criteria;

use App\Queries\CourseListQuery;
use Illuminate\Database\Query\Builder;

interface CourseListCriterion
{
    public function shouldApplyToList(): bool;
    public function applyToListBuilder(Builder $query): Builder;
}