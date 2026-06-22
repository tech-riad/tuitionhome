<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostReviewController extends Controller
{
    public function index(){

        return view('backend.blog.blog_reviews.index');
    }
}
