<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\News;

class Comment extends Model
{
    protected $table = "comments";
    protected $fillable = ['user_id', 'news_id', 'type', 'content'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function news() {
        return $this->belongsTo(News::class);
    }
}
