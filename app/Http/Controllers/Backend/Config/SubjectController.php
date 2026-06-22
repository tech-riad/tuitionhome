<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Imports\SubjectImport;
use App\Models\Subject;
use App\Repositories\SubjectRepository;
use Flash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class SubjectController extends AppBaseController
{
    /** @var SubjectRepository $subjectRepository*/
    private $subjectRepository;

    public function __construct(SubjectRepository $subjectRepo)
    {
        $this->subjectRepository = $subjectRepo;
    }

    /**
     * Display a listing of the Subject.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function subjectsSearch(Request $request)
    {
        $search = $request->input('search');
        // dd($search);

        $subjects = Subject::where('title', 'LIKE', '%'.$search.'%')
            ->paginate(10);

        return view('backend.config.subjects.index',compact('subjects'));
    }
    public function index(Request $request)
    {
        $subjects = $this->subjectRepository->paginate(20);

        return view('backend.config.subjects.index')
            ->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new Subject.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.config.subjects.create');
    }

    /**
     * Store a newly created Subject in storage.
     *
     * @param CreateSubjectRequest $request
     *
     * @return Response
     */
    public function store(CreateSubjectRequest $request)
    {
        $input = $request->all();

        $subject = $this->subjectRepository->create($input);

        Flash::success('Subject saved successfully.');

        return redirect(route('subjects.index'));
    }

    /**
     * Display the specified Subject.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        return view('backend.config.subjects.show')->with('subject', $subject);
    }

    /**
     * Show the form for editing the specified Subject.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        return view('backend.config.subjects.edit')->with('subject', $subject);
    }

    /**
     * Update the specified Subject in storage.
     *
     * @param int $id
     * @param UpdateSubjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubjectRequest $request)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        $subject = $this->subjectRepository->update($request->all(), $id);

        Flash::success('Subject updated successfully.');

        return redirect(route('subjects.index'));
    }

    /**
     * Remove the specified Subject from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        $this->subjectRepository->delete($id);

        Flash::success('Subject deleted successfully.');

        return redirect(route('subjects.index'));
    }
    public function importSubject(Request $request)
    {
        $request->validate([
            'import_subject'=>'required|file|mimes:csv',
        ]);

        Excel::import(new SubjectImport(),$request->file('import_subject'));
        Flash::success('Subject Imported successfully.');
        return redirect()->back();
    }
}
