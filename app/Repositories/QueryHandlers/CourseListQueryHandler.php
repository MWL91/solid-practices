<?php

namespace App\Repositories\QueryHandlers;

use App\Queries\CourseListQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CourseListQueryHandler
{
    public function handle(CourseListQuery $courseListQuery): Collection;

    public function paginate(CourseListQuery $courseListQuery): LengthAwarePaginator;
}