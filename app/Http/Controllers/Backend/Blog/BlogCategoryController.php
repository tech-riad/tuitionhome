<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Category;

class BlogCategoryController extends Controller
{
    public function index(){

        $categories= BlogCategory::orderBy('id', 'desc')->get();
        //  dd($categories);
        return view('backend.blog.blog_category.index', compact('categories'));
    }
    public function store(Request $request){

        $category =new BlogCategory();
        $category->name = $request->cName;
        $category->save();
    }
    public function delete($category){

        $category = BlogCategory::find($category);

        $category->delete();
        return Redirect()->route('blog.category');

    }
    public function edit($category){
        $category= BlogCategory::where('id', $category)->firstOrFail();

        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }
    public function update(Request $request){

       $categorydata=$request->all();
       $id = $categorydata['category_id'];
       $category= BlogCategory::where('id', $id)->firstOrFail();
       $category->update($categorydata);
       return redirect()->route('blog.category')->withMessage('Category Updated Successfully');

    }

}
