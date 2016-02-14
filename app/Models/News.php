<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Comment;
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
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    
    public function parse() {
        if (strpos($this->source, '://') === false)
            $this->source = "//".$this->source;
    
        if (strlen($this->content) > 300)
            $this->content = substr($this->content, 0, 300);
    
        if (strpos($this->banner_source, '://') === false)
            $this->banner_source = "//".$this->banner_source;
        
        return $this;
    }
}
