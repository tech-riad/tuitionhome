<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoTutoial;
use App\Models\VideoTutoialType;
use Illuminate\Foundation\Console\ViewClearCommand;

class VideoTutorialController extends Controller
{
    public function index(){

        $types= VideoTutoialType::orderBy('id', 'desc')->get();
        $tutorials= VideoTutoial::orderBy('id', 'desc')->get();
        return view('backend.video_tutorial.index', compact('types','tutorials'));
    }

    public function store(Request $request){

        $videodata= $request->all();

        $video = VideoTutoial::create($videodata);
        return redirect()->back()->withMessage('Tutorial added Successfully');;
    }

    // public function edit($tutorial){
    //     $types= VideoTutoialType::orderBy('id', 'desc')->get();
    //     $tutorials= VideoTutoial::orderBy('id', 'desc')->get();
    //     return view('backend.video_tutorial.edit', compact('types','tutorials'));

    // }
    public function destroy($tutoial){
      
        $tutorialdata= VideoTutoial::where('id', $tutoial)->firstOrFail();
        $tutorialdata['deleted_by'] = auth()->user()->id;
        $tutorialdata->update();
        $tutorialdata->delete();
        return redirect()->back();
    }

    public function trash()
    {

        dd('tamim');
        $tutorials = VideoTutoial::onlyTrashed()->get();
        return view('backend.video_tutorial.trast', compact('tutorials'));
    }
    public function show(){

        $tutorials = VideoTutoial::onlyTrashed()->get();
        return view('backend.video_tutorial.trast', compact('tutorials'));
    }
    public function restore($tutoial){


        VideoTutoial::withTrashed()
        ->where('id', $tutoial)
        ->restore();
  
        return redirect()->route('tutorial.trash')->withMessage('Successfully Restored !');

    }

    public function edit($tutorial){
        $tutorial= VideoTutoial::where('id', $tutorial)->firstOrFail();

        return response()->json([
            'status'=>200,
            'tutorial'=>$tutorial,
        ]);
    }

    public function update(Request $request){

         $tutorialdata=$request->all();
         $id = $tutorialdata['tutorial_id'];
         $tutorial= VideoTutoial::where('id', $id)->firstOrFail();
         $tutorial->update($tutorialdata);
         return redirect()->route('tutorial.index')->withMessage('Tutorial Updated Successfully');
 
     }


    public function delete($tutoial){

        VideoTutoial::withTrashed()
            ->where('id', $tutoial)
            ->forceDelete();

            return redirect()->back();
    }



}
