<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCurriculaRequest;
use App\Http\Requests\UpdateCurriculaRequest;
use App\Imports\CurriculaImport;
use App\Repositories\CurriculaRepository;
use Flash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class CurriculaController extends AppBaseController
{
    /** @var CurriculaRepository $curriculaRepository*/
    private $curriculaRepository;

    public function __construct(CurriculaRepository $curriculaRepo)
    {
        $this->curriculaRepository = $curriculaRepo;
    }

    /**
     * Display a listing of the Curriculam.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $curriculas = $this->curriculaRepository->paginate(20);

        return view('backend.config.curriculas.index')
            ->with('curriculas', $curriculas);
    }

    /**
     * Show the form for creating a new Curriculam.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.config.curriculas.create');
    }

    /**
     * Store a newly created Curriculam in storage.
     *
     * @param CreateCurriculaRequest $request
     *
     * @return Response
     */
    public function store(CreateCurriculaRequest $request)
    {
        $input = $request->all();

        $curricula = $this->curriculaRepository->create($input);

        Flash::success('Curriculam saved successfully.');

        return redirect(route('curriculas.index'));
    }

    /**
     * Display the specified Curriculam.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $curricula = $this->curriculaRepository->find($id);

        if (empty($curricula)) {
            Flash::error('Curriculam not found');

            return redirect(route('curriculas.index'));
        }

        return view('backend.config.curriculas.show')->with('curricula', $curricula);
    }

    /**
     * Show the form for editing the specified Curriculam.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $curricula = $this->curriculaRepository->find($id);

        if (empty($curricula)) {
            Flash::error('Curriculam not found');

            return redirect(route('curriculas.index'));
        }

        return view('backend.config.curriculas.edit')->with('curricula', $curricula);
    }

    /**
     * Update the specified Curriculam in storage.
     *
     * @param int $id
     * @param UpdateCurriculaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCurriculaRequest $request)
    {
        $curricula = $this->curriculaRepository->find($id);

        if (empty($curricula)) {
            Flash::error('Curriculam not found');

            return redirect(route('curriculas.index'));
        }

        $curricula = $this->curriculaRepository->update($request->all(), $id);

        Flash::success('Curriculam updated successfully.');

        return redirect(route('curriculas.index'));
    }

    /**
     * Remove the specified Curriculam from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $curricula = $this->curriculaRepository->find($id);

        if (empty($curricula)) {
            Flash::error('Curriculam not found');

            return redirect(route('curriculas.index'));
        }

        $this->curriculaRepository->delete($id);

        Flash::success('Curriculam deleted successfully.');

        return redirect(route('curriculas.index'));
    }

    public function importCurricula(Request $request)
    {
        $request->validate([
            'import_curricula'=>'required|file|mimes:csv',
        ]);

//    Excel::import(new CountryImport,$request->file('import_country'));
        Excel::import(new CurriculaImport(),$request->file('import_curricula'));
        Flash::success('Curriculam Imported successfully.');
        return redirect()->back();
    }
}
