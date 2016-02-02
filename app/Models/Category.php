<?php

namespace App\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = ['name', 'permalink', 'order', 'status'];
    
    public function news() {
        return $this->hasMany(News::class);
    }
}
