<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseListRequest;
use App\Models\Category;
use App\Models\InstructionLevel;
use App\Repositories\CourseRepository;
use Illuminate\Contracts\View\View as IView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

final class CourseListController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(CourseListRequest $request): IView
    {






        $categories = $this->courseRepository->getCategories();
        $instruction_levels = $this->courseRepository->getInstructionLevels();

        return View::make(
            'site.course.list',
            [
                'courses' => $courses,
                'categories' => $categories,
                'instruction_levels' => $instruction_levels
            ]
        );
    }
}