<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface InstructorRepository
{
    public function getActive(int $limit): Collection;
}