<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateDegreeRequest;
use App\Http\Requests\UpdateDegreeRequest;
use App\Imports\DegreeImport;
use App\Repositories\DegreeRepository;
use Flash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class DegreeController extends AppBaseController
{
    /** @var DegreeRepository $degreeRepository*/
    private $degreeRepository;

    public function __construct(DegreeRepository $degreeRepo)
    {
        $this->degreeRepository = $degreeRepo;
    }

    /**
     * Display a listing of the Degree.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $degrees = $this->degreeRepository->paginate(20);

        return view('backend.config.degrees.index')
            ->with('degrees', $degrees);
    }

    /**
     * Show the form for creating a new Degree.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.config.degrees.create');
    }

    /**
     * Store a newly created Degree in storage.
     *
     * @param CreateDegreeRequest $request
     *
     * @return Response
     */
    public function store(CreateDegreeRequest $request)
    {
        $input = $request->all();

        $degree = $this->degreeRepository->create($input);

        Flash::success('Degree saved successfully.');

        return redirect(route('degrees.index'));
    }

    /**
     * Display the specified Degree.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $degree = $this->degreeRepository->find($id);

        if (empty($degree)) {
            Flash::error('Degree not found');

            return redirect(route('degrees.index'));
        }

        return view('backend.config.degrees.show')->with('degree', $degree);
    }

    /**
     * Show the form for editing the specified Degree.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $degree = $this->degreeRepository->find($id);

        if (empty($degree)) {
            Flash::error('Degree not found');

            return redirect(route('degrees.index'));
        }

        return view('backend.config.degrees.edit')->with('degree', $degree);
    }

    /**
     * Update the specified Degree in storage.
     *
     * @param int $id
     * @param UpdateDegreeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDegreeRequest $request)
    {
        $degree = $this->degreeRepository->find($id);

        if (empty($degree)) {
            Flash::error('Degree not found');

            return redirect(route('degrees.index'));
        }

        $degree = $this->degreeRepository->update($request->all(), $id);

        Flash::success('Degree updated successfully.');

        return redirect(route('degrees.index'));
    }

    /**
     * Remove the specified Degree from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $degree = $this->degreeRepository->find($id);

        if (empty($degree)) {
            Flash::error('Degree not found');

            return redirect(route('degrees.index'));
        }

        $this->degreeRepository->delete($id);

        Flash::success('Degree deleted successfully.');

        return redirect(route('degrees.index'));
    }

    public function importDegree(Request $request)
    {
        $request->validate([
            'import_degree'=>'required|file|mimes:csv',
        ]);

//    Excel::import(new CountryImport,$request->file('import_country'));
        Excel::import(new DegreeImport(),$request->file('import_degree'));
        Flash::success('Degree Imported successfully.');
        return redirect()->back();
    }
}
