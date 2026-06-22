<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\Controller;
use App\Models\Backend\Config\TutorRequirementTemplate;
use Illuminate\Http\Request;

class TutorRequirementTemplateController extends Controller
{
    public function index()
    {
        $templates = TutorRequirementTemplate::all();
        return view('backend.config.requirementtemp.index',compact('templates'));

    }

    public function create()
    {
        return view('backend.config.requirementtemp.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $template = new TutorRequirementTemplate();

        $template->title = $request->input('title');
        $template->body  = $request->input('body');

        $template->save();

        return redirect()->route('admin.config.requirement.template')->withMessage('Template Added');
    }
    public function edit($id)
    {
        $template = TutorRequirementTemplate::find($id);


        return view('backend.config.requirementtemp.edit',compact('template'));


    }


    public function update(Request $request ,$id)
    {

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $template = TutorRequirementTemplate::findOrFail($id);

        $template->title = $request->input('title');
        $template->body = $request->input('body');

        $template->save();

        return redirect()->route('admin.config.requirement.template')->withMessage('Update Successfull');
    }

    public function destroy($id)
    {
        $template = TutorRequirementTemplate::findOrFail($id);

        $template->delete();

        return redirect()->route('admin.config.requirement.template')->withMessage('Update Successfull');
    }




}
