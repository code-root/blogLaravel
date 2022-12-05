<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\Post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

// use function PHPUnit\Framework\isEmpty;

class PostController extends Controller
{
    // return view('dashboard.AddPost');

    public function index()
    {
        $posts = Post::where('active', 0)->get(); //fetch all blog posts from DB
	return view('dashboard.post', [
            'posts' => $posts,
        ]); //returns the view with posts

    }

    public function comment_add (Request $request) {
        // user_id post_id comment
        $user_id = Auth::user()->id;
        $request->validate([
            'post_id' => 'required|numeric',
            'comment' => 'required|string',
        ]);
        $comment = new comment;
        $comment->user_id = $user_id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        $comment->active = 0;
        $comment->save();
        return back()->with('status', 'done !');

    }

    public function  delete_post (Request $request){
        $request->validate([
            'post_id' => 'required|numeric',
        ]);

        $postId =  $request->post_id;
        $post = Post::find($postId);
        $user_id = Auth::user()->id;
        $userId_post = $post->user_id;

        if ($user_id == $userId_post ) {
            Post::where('id', $postId)->update(['active' => 1]);
            $msg = "done post deleted";
        }else {
            $msg = "You have no permissions";
        }
        return back()->withErrors([$msg]);

    }


    public function   delete_comment (Request $request) {

        $request->validate([
            'comment_id' => 'required|numeric',
        ]);

        $comment_id =  $request->comment_id;
        $comment = comment::find($comment_id);
        $user_id = Auth::user()->id;
        $userId_comment = $comment->user_id;

        if ($user_id == $userId_comment ) {
            comment::where('id', $comment_id)->update(['active' => 1]);
            $msg = "delete comment";
        }else {
            $msg = "You have no permissions";
        }
        return back()->withErrors([$msg]);

    }



    public function cerate (Request $request) {
        $user_id = Auth::user()->id;

        // [ png, jpg, webp ]
        $request->validate([
            'image' => 'required|image|mimes:webp,png,jpg|max:2048',
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
    // id	user_id	title	content	image	active	created_at	updated_at
    $post = new Post;
    $post->user_id = $user_id;
    $post->title = $request->title;
    $post->content = $request->content;
    $post->image = imageUploadPost($request);
    $post->active = 0;
    $post->save();
    return redirect('blog/post')->with('status', 'Blog Post Form Data Has Been inserted');

    }

    public function postId(Request $request) {

        $postId =  $request->postId;
        $post = Post::find($postId);
        // $comment = comment::where('post_id',$postId)->get(); //fetch all blog posts from DB
        $comment = comment::select('*','comments.created_at as created_comments' , 'comments.id as commentId')->join('users', 'users.id', '=', 'comments.user_id')->where('comments.post_id', $postId)->where('comments.active',0)->get();

        if (empty($post)) {
            return redirect('blog/post')->with('status', 'post found');
        }else {
            return view('dashboard.show', [
                "post" => $post,
                "comment" => $comment,
            ]); //returns the view with the post And comment
            // return $comment;
        }

}

    public function show () {
        return view('dashboard.AddPost');

    }


    public function store()
    {

    }

}
