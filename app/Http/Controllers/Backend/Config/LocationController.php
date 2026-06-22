<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Imports\LocationImport;
use App\Models\City;
use App\Models\Country;
use App\Models\Location;
use App\Repositories\LocationRepository;
use Flash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class LocationController extends AppBaseController
{
    /** @var LocationRepository $locationRepository*/
    private $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        $this->locationRepository = $locationRepo;
    }

    /**
     * Display a listing of the Location.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $locations = $this->locationRepository->paginate(20);
       $locations  = Location::with(['country','city'])->where('name', '!=', 'Error')->paginate(20);
        return view('backend.config.locations.index')
            ->with('locations', $locations);
    }

    /**
     * Show the form for creating a new Location.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::orderBy('id','ASC')->get();
        $cities = City::orderBy('id','ASC')->get();
        return view('backend.config.locations.create',compact('countries','cities'));
    }

    /**
     * Store a newly created Location in storage.
     *
     * @param CreateLocationRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationRequest $request)
    {
        $input = $request->all();

        $location = $this->locationRepository->create($input);

        Flash::success('Location saved successfully.');

        return redirect(route('locations.index'));
    }

    /**
     * Display the specified Location.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        return view('backend.config.locations.show')->with('location', $location);
    }

    /**
     * Show the form for editing the specified Location.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        return view('backend.config.locations.edit')->with('location', $location);
    }

    /**
     * Update the specified Location in storage.
     *
     * @param int $id
     * @param UpdateLocationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationRequest $request)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        $location = $this->locationRepository->update($request->all(), $id);

        Flash::success('Location updated successfully.');

        return redirect(route('locations.index'));
    }

    /**
     * Remove the specified Location from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        $this->locationRepository->delete($id);

        Flash::success('Location deleted successfully.');

        return redirect(route('locations.index'));
    }

    public function importLocation(Request $request)
    {
        $request->validate([
            'import_location'=>'required|file|mimes:csv',
        ]);

//    Excel::import(new CountryImport,$request->file('import_country'));
        Excel::import(new LocationImport(),$request->file('import_location'));
        Flash::success('Location Imported successfully.');
        return redirect()->back();
    }

    public function getLocation(Request $request)
    {
        $city_id = $request->city_id;
        $locations = Location::where('city_id',$city_id)->where('name', '!=', 'Error')->orderBy('name','asc')->get();
        $html = '<option value="">~Select Location~</option>';
        foreach ( $locations as $location)
        {
            $html.='<option value="'.$location->id.'">'.$location->name.'</option>';

        }
        echo $html;
    }

    public function locationSearch(Request $request)
    {
        $search = $request->input('search');

        $location = Location::with('country')
            ->where('name', '!=', 'Error')
            ->where('name', 'LIKE', '%'.$search.'%')
            ->paginate(10);

        return view('backend.config.locations.search_location_result',compact('location'));
    }
}
