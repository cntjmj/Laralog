<?php
namespace App\Repositories;

use App\User;
use App\Models\News;
use App\Models\Comment;

class CommentRepository {
    public function forNews($news_id) {
        return Comment::with('user')
                      ->where('news_id', $news_id)
                      ->orderBy('created_at', 'desc')
                      ->get();
    }
}
?>