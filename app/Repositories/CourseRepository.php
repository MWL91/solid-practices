<?php

namespace App\Repositories;

use App\Queries\CourseListQuery;
use Illuminate\Support\Collection;

interface CourseRepository
{

    public function getLatestCourses(int $limit): Collection;

    public function getFreeCourses(int $limit): Collection;

    public function getDiscountCourses(int $limit): Collection;

    public function getCategories(bool $active = true): Collection;

    public function getInstructionLevels(): Collection;

    public function getListing(CourseListQuery $courseListQuery): Collection;
}