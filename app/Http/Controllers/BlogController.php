<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogPostComment;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{
    public function index(){

       
         $posts= BlogPost::orderBy('id', 'desc')->get();
        //  dd($comments);
        return view('frontend.blog.index', compact('posts'));
    }
    public function show($post){


         $id=$post;
         $postdata= BlogPost::where('id', $id)->firstOrFail();
         $comments= BlogPostComment::orderBy('id', 'desc')->get();
         $posts= BlogPost::orderBy('id', 'desc')->get();

        //  dd($tag);
        //  dd($category_id);
         return view('frontend.blog.show', compact('postdata','comments','posts'));


        dd($post);

    }
}
