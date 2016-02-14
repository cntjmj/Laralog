<?php

namespace App\Repositories;

use App\User;
use App\Models\News;
use App\Models\Category;

class NewsRepository
{
    /**
     * Get news list for a certain category
     *
     * @param  $page, $num, $category_id
     * @return Collection
     */
    public function forCategory($page, $num, $category_id)
    {
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

        return $this->parseNewsList($newsList);
    }

    public function hotNews($category_id = -1)
    {
        /*
         * supposed to be the news with most replies
         */
        if ($category_id < 0) {
            $query = News::with('category');
        } else {
        	$category = Category::findOrFail($category_id);
            $query = $category->news()->with('category');
        }

        $hotNews = $query->where('status', 'active')
                         ->orderBy('created_at', 'desc')
                         ->take(5)
                         ->get();

        return $this->parseNewsList($hotNews);
    }

    public function trendingNews($category_id = -1)
    {
        /*
         * the news most visited
         */
    	if ($category_id < 0) {
    		$query = News::with('category');
    	} else {
    		$category = Category::findOrFail($category_id);
    		$query = $category->news()->with('category');
    	}
    	
    	$trendingNews = $query->where('status', 'active')
    	                      ->orderBy('visit', 'desc')
    	                      ->take(2)
    	                      ->get();
    	
    	return $this->parseNewsList($trendingNews);
    }
    
    private function parseNewsList($newsList)
    {
        foreach ($newsList as $news) {
            if (strpos($news->source, '://') === false)
                $news->source = "//".$news->source;
    
            if (strlen($news->content) > 300)
                $news->content = substr($news->content, 0, 300);

            if (strpos($news->banner_source, '://') === false)
                $news->banner_source = "//".$news->banner_source;
        }

        return $newsList;
    }
}

?>