<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Database\QueryException;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToArray;

class BlogPostsController extends Controller
{
    public function index(){

        $posts= BlogPost::orderBy('id', 'desc')->get();
        return view('backend.blog.blog_posts.index', compact('posts'));
    }

    public function show($post){

         $id=$post;
         $postdata= BlogPost::where('id', $id)->firstOrFail();
         $category_id=$postdata->category_id;   
         $tag_id=$postdata->tag_id;
         $category = DB::table('blog_categories')->where('id',$category_id)->value('name');
         $tag = DB::table('blog_tags')->where('id',$tag_id)->value('name');


         return view('backend.blog.blog_posts.show', compact('postdata','category','tag'));

    }

    public function create(){

        $categories= BlogCategory::orderBy('id', 'desc')->get();
        $tags= BlogTag::orderBy('id', 'desc')->get();

        return view('backend.blog.blog_posts.create', compact('categories','tags'));
    }


    public function edit($post){


        $postdata= BlogPost::where('id', $post)->firstOrFail();
        $category_id=$postdata->category_id;
        $tag_id=$postdata->tag_id;

        $category = DB::table('blog_categories')->where('id',$category_id)->value('name');
        $tag = DB::table('blog_tags')->where('id',$tag_id)->value('name');

        $categories= BlogCategory::orderBy('id', 'desc')->get();
        $tags= BlogTag::orderBy('id', 'desc')->get();

        // dd($tags);

        return view('backend.blog.blog_posts.edit', compact('postdata','category','tag','categories','tags'));
    }

    public function update(Request $request ,BlogPost $post){

        $postdata=$request->all();
     try{
        
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            Image::make($request->file('image'))
                ->resize(300, 200)
                ->save(storage_path() . '/app/public/post-image/' . $fileName);
            $postdata['image'] = $fileName;

            // delete old image
            $post_id= $post->id;
            $post= BlogPost::where('id',$post_id)->first();
            $deleteImage= 'storage/post-image/'.$post->image;

            if (file_exists($deleteImage)) {
    
                File::delete($deleteImage);
             }
        }
        
        else {
            $postdata['image'] = $post->image;
        }

        $post->update($postdata);
        return redirect()->route('blog.posts')->withMessage('Successfully Updated !');
     }

     catch (QueryException $e) {
        return redirect()->back()->withInput()->withErrors($e->getMessage());
      }
        
       
    }

    public function store(Request $request){
      
        try{
            $postdata=$request->all();
            $postdata['created_by'] = Auth::id();
            // dd($postdata);              
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                Image::make($request->file('image'))
                    ->resize(300, 200)
                     ->save(storage_path() . '/app/public/post-image/' . $fileName);
                    $postdata['image'] = $fileName;

            }
    
            $postdata['created_by'] = auth()->user()->id;
            // dd($postdata);
            $post= BlogPost::create($postdata);
   
            return Redirect()->route('blog.posts')->withMessage('Post uploaded Successfully');
    
        }
    
        catch (QueryException $e) 
        
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function delete($post)
    {

        $blogPost = BlogPost::find($post);
        $postdata = DB::table('blog_posts')->where('id',$post)->get()->first();
        $deleteImage= 'storage/post-image/'.$postdata->image;

        if (file_exists($deleteImage)) {
    
            File::delete($deleteImage);
         }
       $blogPost->delete();

        return Redirect()->route('blog.posts');
    }




    
}
