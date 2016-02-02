<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $table = "news";
    protected $fillable = ['category_id', 'permalink', 'banner', 'banner_source',
        'source', 'title', 'desc', 'tag', 'content', 'question', 'start_date',
        'status', 'visit', 'user_id'];
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
