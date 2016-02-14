<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\News;
use App\User;
use App\Models\Comment;
use App\Repositories\NewsRepository;

class HomeController extends Controller
{
    protected $news;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NewsRepository $news)
    {
        //$this->middleware('auth');
        $this->news = $news;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indeks()
    {
        return view('home');
    }
    
    public function test()
    {
        $categories = Category::all();
        return view('pages.test', [
            'title' => 'Test',
        ]);
    }
    
    protected function buildNav($categories, $category_id) {
        $navEntry = collect([
            "text"  => "All",
            "url"   => $category_id<0?"javascript:;":url("/home"),
            "class" => $category_id<0?"active":"",
        ]);
        
        $navEntries = collect([$navEntry,]);
        
        foreach ($categories as $category) {
            $navEntry = collect([
                "text"  => $category->name,
                "url"   => $category->id==$category_id?"javascript:;":url("/home/".$category->id),
                "class" => $category->id==$category_id?"active":"",
            ]);
            
            $navEntries->push($navEntry);
        }
        
        return $navEntries;
    }
    
    public function index($category_id = -1)
    {
        $b4login = session('b4login');
        if (true == Auth::check() && '' != $b4login) {
            session()->forget('b4login');
            return redirect($b4login);
        }

        $title = "All News";
        $categories = Category::all();
        $script = "<script>var category_id = $category_id;</script>";

    	if ($category_id >= 0) {
            $category = Category::find($category_id);
            $title = $category->name." News";
        }
        
        $navEntries = $this->buildNav($categories, $category_id);
        
        $hotNews = $this->news->hotNews($category_id);
        $trendingNews = $this->news->trendingNews($category_id);

        return view('pages.home', [
            'ngController' => 'HomeController',
            'title'        => $title,
            //'categories'   => $categories,
            'navEntries'   => $navEntries,
            'category_id'  => $category_id,
        	'hotNews'      => $hotNews->toArray(),
        	'trendingNews' => $trendingNews->toArray(),
            'script'       => $script,
        ]);
    }
    
    public function news($news_id)
    {
    	$user_id = 0;
    	if (Auth::check()) {
    	    $user_id = Auth::user()->id;
    	}
        $script = "<script>\n\t\tvar news_id = $news_id;\n\t\tvar user_id=$user_id;\n\t</script>";
        
        $news = News::findOrFail($news_id);
        
        try {
            DB::beginTransaction();
            $news->increment("visit");
            $news->save();
            DB::commit();
        } catch(Exception $exception) {
            DB::rollback();
        }
        
        return view('pages.news', [
            'ngController' => 'NewsController',
            'title' => $news->title,
        	'news' => $news->parse(),
            'script' => $script,
        ]);
    }
}
