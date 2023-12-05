<?php

namespace App\Repositories\QueryHandlers;

use App\Queries\CourseListQuery;
use Illuminate\Support\Collection;

interface CourseListQueryHandler
{
    public function handle(CourseListQuery $courseListQuery): Collection;
}