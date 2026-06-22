<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogTag;


class BlogTagsController extends Controller
{
    public function index(){

        $tags= BlogTag::orderBy('id', 'desc')->get();
        return view('backend.blog.blog_tags.index', compact('tags'));

    }
    public function store(Request $request){
        $tag =new BlogTag();
        $tag->name = $request->tName;
        $tag->save();
    }
    public function delete($tag){

        $tag = BlogTag::find($tag);
        $tag->delete();
        return Redirect()->route('blog.tag.index');

    }
    public function edit($tag){
        $tag= BlogTag::where('id', $tag)->firstOrFail();

        return response()->json([
            'status'=>200,
            'tag'=>$tag,
        ]);
    }
    public function update(Request $request){

       $tagdata=$request->all();
       $id = $tagdata['tag_id'];
       $tag= BlogTag::where('id', $id)->firstOrFail();
       $tag->update($tagdata);
       return redirect()->route('blog.tag.index')->withMessage('Tag Updated Successfully');
    }


}
