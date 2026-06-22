<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogPostComment;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PostCommentController extends Controller
{
    public function store(Request $request){

            $Commentdata=$request->all();
            $comment= BlogPostComment::create($Commentdata);
             return Redirect()->back();      
       

    }
    public function  show(){

        dd('tamim');
    }
    public function index(){

        $comments= BlogPostComment::orderBy('id', 'desc')->get();
        return view('backend.blog.blog_comment.index',compact('comments'));

    }
    public function delete($comment){

        $comment = BlogPostComment::find($comment);
        $comment->delete();
        return Redirect()->route('blog.comment.index');

    }
}
