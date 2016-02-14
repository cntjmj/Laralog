<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Exception;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Category;
use App\Models\News;
use App\Models\Comment;
use App\Repositories\NewsRepository;
use App\Repositories\CommentRepository;

class ApiController extends Controller
{
	protected $news;
	protected $comment;

    public function __construct(NewsRepository $news, CommentRepository $comment)
    {
        $this->middleware('auth', ['only' => ['postComment', 'deleteComment', 'getUser']]);
        $this->news = $news;
        $this->comment = $comment;
    }
    
    public function getNewsList(Request $request, $category_id = -1)
    {
        $num = $request->num>0?$request->num:5;
        $page = $request->page>-1?$request->page:0;

        $newsList = $this->news->forCategory($page, $num, $category_id);

        return ['newsList' => $newsList];
    }
    
    public function getNewsComments($news_id) {
        return json_encode(['comments' => $this->comment->forNews($news_id)]);
    }

    public function postComment(Request $request, $news_id) {
        $this->validate($request, [
            'type' => 'in:agree,disagree',
            'content' => 'required|between:1,100',
        ]);
        
        $news = News::findOrFail($news_id);
        $comment = new Comment(['type'=>$request->type, 'content'=>$request->content, 'user_id'=>Auth::user()->id]);
        $news->comments()->save($comment);

        return json_encode(['comments' => $this->comment->forNews($news_id)]);
    }
    
    public function deleteComment($comment_id) {
        $comment = Comment::findOrFail($comment_id);
        
        if ($comment->user_id != Auth::user()->id)
            abort(403, 'unauthorized deletion');
        
        return json_encode(['success' => $comment->delete()?'true':'false']);
    }
    
    public function getUser($user_id) {
    	try {
        $user = User::find($user_id);
        
        if ($user == null) {
        	throw new Exception("user not found", 404);
        }

        if ($user->id != Auth::user()->id) {
            throw new Exception("unauthorized user", 403);
        }
        
        return json_encode(['user' => $user]);
    	} catch (Exception $e) {
    		return Response::json(['errMsg' => $e->getMessage()], $e->getCode());
    	}
    }
}
