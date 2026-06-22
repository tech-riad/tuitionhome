<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Imports\CityImport;
use App\Models\City;
use App\Models\Country;
use App\Repositories\CityRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class CityController extends AppBaseController
{
    /** @var CityRepository $cityRepository*/
    private $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
    }

    /**
     * Display a listing of the City.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function citiesSearch(Request $request)
    {
        $search = $request->input('search');

        $cities = DB::table('cities')
            ->select('cities.*', 'countries.name as country_name')
            ->leftJoin('countries', 'cities.country_id', 'countries.id')
            ->where('cities.name', 'LIKE', '%' . $search . '%')
            ->orWhere('countries.name', 'LIKE', '%' . $search . '%')
            ->orderBy('cities.id', 'DESC')
            ->paginate(10);

        return view('backend.config.cities.index', compact('cities'));
    }

    public function index(Request $request)
    {

        $cities = DB::table('cities')
            ->select('cities.*','countries.name as country_name')
            ->leftJoin('countries','cities.country_id','countries.id')
            ->orderBy('id','DESC')
            ->paginate(10);
        return view('backend.config.cities.index')
            ->with('cities', $cities);
    }

    /**
     * Show the form for creating a new City.
     *
     * @return Response
     */
    public function create()
    {
//        $countries = Country::orderBy('id','ASC')->get();
//        return $countries;
        return view('backend.config.cities.create');
    }

    /**
     * Store a newly created City in storage.
     *
     * @param CreateCityRequest $request
     *
     * @return Response
     */
    public function store(CreateCityRequest $request)
    {

        // $request->validate([
        //     'name' => 'required|uniquqe:name,cities'
        //  ]);
        $input = $request->all();

        $city = $this->cityRepository->create($input);

        Flash::success('City saved successfully.');

        return redirect()->route('cities.index');
    }

    /**
     * Display the specified City.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            Flash::error('City not found');

            return redirect()->route('cities.index');
        }

        return view('backend.config.cities.show')->with('city', $city);
    }

    /**
     * Show the form for editing the specified City.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            Flash::error('City not found');

            return redirect()->route('cities.index');
        }

        return view('backend.config.cities.edit')->with('city', $city);
    }

    /**
     * Update the specified City in storage.
     *
     * @param int $id
     * @param UpdateCityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCityRequest $request)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            Flash::error('City not found');

            return redirect()->route('cities.edit');
        }

        $city = $this->cityRepository->update($request->all(), $id);

        Flash::success('City updated successfully.');

        return redirect()->route('cities.index');
    }

    /**
     * Remove the specified City from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $city = $this->cityRepository->find($id);



        if (empty($city)) {
            Flash::error('City not found');

            return redirect()->route('cities.index');
        }

        $this->cityRepository->delete($id);

        Flash::success('City deleted successfully.');

        return redirect()->route('cities.index');
    }

    public function importCountry(Request $request)
    {
        $request->validate([
            'import_city'=>'required|file|mimes:csv',
        ]);

//    Excel::import(new CountryImport,$request->file('import_country'));
        Excel::import(new CityImport(),$request->file('import_city'));
        Flash::success('City Imported successfully.');
        return redirect()->back();

    }

    public function getCity(Request $request)
    {
      $c_id = $request->c_id;
        $cities = City::where('country_id',$c_id)->orderBy('name','asc')->get();
       $html = '<option value="">~select City~</option>';
       foreach ( $cities as $city)
       {
           $html.='<option value="'.$city->id.'">'.$city->name.'</option>';

       }
       echo $html;
    }
}
