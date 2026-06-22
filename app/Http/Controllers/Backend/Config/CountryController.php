<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\Controller;
use App\Imports\CountryImport;
use App\Models\Country;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('backend.config.country.index',compact('countries'));
    }

    public function store(Request $request)
    {
//        return $request->all();
        Country::CountryStore($request);
        return back();
    }
    public function edit($id)
    {
        $country = Country::find($id);
        return view('backend.config.country.edit',compact('country'));
    }
    public function update(Request $request,$id)
    {
        Country::updateCountry($request,$id);
        return redirect('admin/config/country/index')->with('message','Country Update Successfully');
    }
    public function delete($id)
    {

        Country::deleteCountry($id);
        return redirect('admin/config/country/index')->with('message','Country Delete Successfully');

    }

//    import country function

public function importCountry(Request $request)
{
   $request->validate([
      'import_country'=>'required|file|mimes:csv',
   ]);

//    Excel::import(new CountryImport,$request->file('import_country'));
   Excel::import(new CountryImport(),$request->file('import_country'));
    return redirect()->back()->with('message','Country Import successfully');

}


}
