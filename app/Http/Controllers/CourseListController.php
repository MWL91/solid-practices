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
        $paginate_count = $request->get('paginate', 9);

        $category_search = $request->getQuery()->getCategoryId();
        $instruction_level_id = $request->getQuery()->getInstructionLevelId();
        $prices = $request->getQuery()->getPriceId();
        $sort_price = $request->getQuery()->getSort();

        $query = DB::table('courses')
            ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
            ->selectRaw('AVG(course_ratings.rating) AS average_rating')
            ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
            ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
            ->where('courses.is_active',1);
        //filter categories as per user selected
        if($category_search) {
            $query->whereIn('courses.category_id', $category_search);
        }

        //filter instruction levels as per user selected
        if($instruction_level_id) {
            $query->whereIn('courses.instruction_level_id', $instruction_level_id);
        }

        //filter price as per user selected
        if($prices)
        {
            $price_count = count($prices);
            $is_greater_500 = false;
            // echo $price_count;exit;
            foreach ($prices as $p => $price) {
                $p++;
                $price_split = explode('-', $price);

                if($price_count == 1)
                {
                    $from = $price_split[0];
                    if($price == 500)
                    {
                        $is_greater_500 = true;
                    }
                    else
                    {
                        $to = $price_split[1];
                    }

                }
                elseif($p==1)
                {
                    $from = $price_split[0];
                }
                elseif($p==$price_count)
                {

                    if($price == 500)
                    {
                        $is_greater_500 = true;
                    }
                    else
                    {
                        $to = $price_split[1];
                    }

                }

            }
            $query->where('courses.price', '>=', $from);
            if(!$is_greater_500)
            {
                $query->where('courses.price', '<=', $to);
            }
        }


        //filter categories as per user selected
        if($sort_price) {
            $query->orderBy('courses.price', $sort_price);
        }

        $courses = $query->groupBy('courses.id')->paginate($paginate_count);

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