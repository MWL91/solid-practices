<?php
declare(strict_types=1);

namespace App\Repositories\Db;

use App\Repositories\InstructorRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InstructorRepositoryDb implements InstructorRepository
{

    public function getActive(int $limit): Collection
    {
        return DB::table('instructors')
            ->select('instructors.*')
            ->join('users', 'users.id', '=', 'instructors.user_id')
            ->where('users.is_active',true)
            ->groupBy('instructors.id')
            ->limit($limit)
            ->get();
    }
}