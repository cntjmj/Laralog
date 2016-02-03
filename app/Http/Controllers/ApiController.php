<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;

class ApiController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function newsList(Request $request, $category_id = -1)
    {
        $num = $request->num>0?$request->num:5;
        $page = $request->page>-1?$request->page:0;
        
        if ($category_id < 0) {
            $newsList = News::with('category')
                            ->where('status', 'active')
                            ->orderBy('created_at')
                            ->skip($num * $page)
                            ->take($num)
                            ->get();
        } else {
            $category = Category::findOrFail($category_id);
            $newsList = $category->news()
                                 ->with('category')
                                 ->where('status', 'active')
                                 ->orderBy('created_at')
                                 ->skip($num * $page)
                                 ->take($num)
                                 ->get();
        }

        return ["newsList" => $this->parseNewsList($newsList)];
    }
    
    private function parseNewsList($newsList) {
        foreach ($newsList as $news) {
            if (strpos($news->source, '://') === false)
                $news->source = "//".$news->source;

            if (strlen($news->content) > 300)
                $news->content = substr($news->content, 0, 300);
        }
        
        return $newsList;
    }
}
