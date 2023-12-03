<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactAdmin;
use App\Models\Config;

class HomeController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $latestTab_courses = $this->courseRepository->getLatestCourses($request->get('limit', 8));
        $freeTab_courses = $this->courseRepository->getFreeCourses($request->get('limit', 8));
        $discountTab_courses = $this->courseRepository->getDiscountCourses($request->get('limit', 8));

        $instructors = DB::table('instructors')
                        ->select('instructors.*')
                        ->join('users', 'users.id', '=', 'instructors.user_id')
                        ->where('users.is_active',1)
                        ->groupBy('instructors.id')
                        ->limit(8)
                        ->get();

        return view('site/home', compact('latestTab_courses', 'freeTab_courses', 'discountTab_courses', 'instructors'));
    }

    /**
     * Function to check whether the email already exists
     *
     * @param array $request All input values from form
     *
     * @return true or false
     */
    public function checkUserEmailExists(Request $request)
    {
        $email = $request->input('email');
        
        $users = User::where('email',$email)->first();
        
        echo $users ? "false" : "true";
    }

    public function blogList(Request $request)
    {
        $paginate_count = 3;
        $blogs =  Blog::where('is_active',1)
                    ->paginate($paginate_count);

        $archieves = DB::table('blogs')
                ->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) blog_count'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        
        return view('site.blogs.list', compact('blogs', 'archieves'));
    }

    public function blogView($blog_slug = '', Request $request)
    {
        $paginate_count = 1;
        $blog =  Blog::where('blog_slug',$blog_slug)->first();

        $archieves = DB::table('blogs')
                ->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) blog_count'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

        return view('site.blogs.view', compact('blog', 'archieves'));
    }

    public function pageAbout(Request $request)
    {
        return view('site.pages.about');
    }

    public function pageContact(Request $request)
    {
        return view('site.pages.contact');
    }

    public function contactAdmin(Request $request)
    {   
        $admin_email = Config::get_option('settingGeneral', 'admin_email');
        Mail::to($admin_email)->send(new ContactAdmin($request));
        return $this->return_output('flash', 'success', 'Thanks for your message, will contact you shortly', 'back', '200');
    }

    public function getCheckTime()
	{
		$reset_site_at = Config::get_option('lastResetTime', 'lastResetTime');
		
		$reset_minutes = 60 * 60;
        
        if(($reset_site_at+$reset_minutes) - time() > 0)
		{
			echo ($reset_site_at+$reset_minutes) - time();
		}
		else
		{
			echo $reset_minutes;
		}
		
	}
}
