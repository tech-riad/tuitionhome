<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateInstituteRequest;
use App\Http\Requests\UpdateInstituteRequest;
use App\Imports\InstituteImport;
use App\Models\Institute;
use App\Repositories\InstituteRepository;
use Flash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class InstituteController extends AppBaseController
{
    /** @var InstituteRepository $instituteRepository*/
    private $instituteRepository;

    public function __construct(InstituteRepository $instituteRepo)
    {
        $this->instituteRepository = $instituteRepo;
    }

    /**
     * Display a listing of the Institute.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $institutes = Institute::orderBy('id', 'desc')->paginate(10);


        return view('backend.config.institutes.index')
            ->with('institutes', $institutes);
    }

    public function search(Request $request)
    {
        $searchInput = $request->input('searchInput');

        $institutes = Institute::where('title', 'LIKE', "%$searchInput%")->paginate(10);

        return response()->json([
            'institutes' => $institutes,
            'pagination' => $institutes->links()->toHtml() // Return pagination as HTML
        ]);
    }






    /**
     * Show the form for creating a new Institute.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.config.institutes.create');
    }

    /**
     * Store a newly created Institute in storage.
     *
     * @param CreateInstituteRequest $request
     *
     * @return Response
     */
    public function store(CreateInstituteRequest $request)
    {
        $input = $request->all();

        $institute = $this->instituteRepository->create($input);

        Flash::success('Institute saved successfully.');

        return redirect(route('institutes.index'));
    }

    /**
     * Display the specified Institute.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $institute = $this->instituteRepository->find($id);

        if (empty($institute)) {
            Flash::error('Institute not found');

            return redirect(route('institutes.index'));
        }

        return view('backend.config.institutes.show')->with('institute', $institute);
    }

    /**
     * Show the form for editing the specified Institute.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $institute = $this->instituteRepository->find($id);

        if (empty($institute)) {
            Flash::error('Institute not found');

            return redirect(route('institutes.index'));
        }

        return view('backend.config.institutes.edit')->with('institute', $institute);
    }

    /**
     * Update the specified Institute in storage.
     *
     * @param int $id
     * @param UpdateInstituteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInstituteRequest $request)
    {
        $institute = $this->instituteRepository->find($id);

        if (empty($institute)) {
            Flash::error('Institute not found');

            return redirect(route('institutes.index'));
        }

        $institute = $this->instituteRepository->update($request->all(), $id);

        Flash::success('Institute updated successfully.');

        return redirect(route('institutes.index'));
    }

    /**
     * Remove the specified Institute from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $institute = $this->instituteRepository->find($id);

        if (empty($institute)) {
            Flash::error('Institute not found');

            return redirect(route('institutes.index'));
        }

        $this->instituteRepository->delete($id);

        Flash::success('Institute deleted successfully.');

        return redirect(route('institutes.index'));
    }

    public function importInstitute(Request $request)
    {
        $request->validate([
            'import_institute'=>'required|file|mimes:csv',
        ]);

        Excel::import(new InstituteImport(),$request->file('import_institute'));
        Flash::success('Institute Imported successfully.');
        return redirect()->back();
    }
}
