<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
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
    			'categories' => $categories,
    			'title' => 'Test',
    	]);
    }
    
    public function index($category_id = -1)
    {
    	$title = "All News";
    	$categories = Category::all();
    	if ($category_id >= 0)
    	{
    	    $category = Category::find($category_id);
    	    $title = $category->name." News";
    	}

        return view('pages.home', [
            'title' => $title,
            'categories' => $categories,
            'category_id' => $category_id,
        ]);
    }
}
