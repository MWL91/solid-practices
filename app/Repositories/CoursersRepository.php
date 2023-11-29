<?php

na mespace App\Repositories;

use Illuminate\Support\Collection;

interface CoursersRepository
{

    public function getLatestCourses(int $limit): Collection;

    public function getFreeCourses(int $limit): Collection;

    public function getDiscountCourses(int $limit): Collection;
}