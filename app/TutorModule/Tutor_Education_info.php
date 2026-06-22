<?php

namespace App\TutorModule;

use App\Models\TutorEducation;
use Illuminate\Support\Facades\Auth;

class Tutor_Education_info
{
    public function updateSSC($request)
    {
        $tutor_id = $request->tutor_id;

        $ssc = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'ssc'])->first();
        if ($ssc != null)
        {
            $sscUpdate = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'ssc'])->first();
            $sscUpdate->institute_id = $request->school_id;
            $sscUpdate->curriculum_id =$request->school_curriculum_id;
            $sscUpdate->degree_name ='ssc';
            $sscUpdate->gpa =$request->school_gpa;
            $sscUpdate->group_or_major =$request->school_group;
            $sscUpdate->education_board =$request->school_board;
            $sscUpdate->passing_year =$request->school_year;
            $sscUpdate->save();


        }else
        {
            $sscInsert = new TutorEducation();
            $sscInsert->tutor_id = $tutor_id;
            $sscInsert->institute_id = $request->school_id;
            $sscInsert->curriculum_id =$request->school_curriculum_id;
            $sscInsert->degree_name ='ssc';
            $sscInsert->gpa =$request->school_gpa;
            $sscInsert->group_or_major =$request->school_group;
            $sscInsert->education_board =$request->school_board;
            $sscInsert->passing_year =$request->school_year;
            $sscInsert->save();

        }

    }

    public function updateHSC($request)
    {
        $tutor_id = $request->tutor_id;
        $hsc = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'hsc'])->first();
        if ($hsc != null)
        {
            $hscUpdate = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'hsc'])->first();
            $hscUpdate->institute_id = $request->college_id;
            $hscUpdate->curriculum_id =$request->college_curriculum_id;
            $hscUpdate->degree_name ='hsc';
            $hscUpdate->gpa =$request->college_gpa;
            $hscUpdate->group_or_major =$request->college_group;
            $hscUpdate->education_board =$request->college_board;
            $hscUpdate->passing_year =$request->college_year;
            $hscUpdate->save();


        }else
        {
            $hscInsert = new TutorEducation();
            $hscInsert->tutor_id = $tutor_id;
            $hscInsert->institute_id = $request->college_id;
            $hscInsert->curriculum_id =$request->college_curriculum_id;
            $hscInsert->degree_name ='hsc';
            $hscInsert->gpa =$request->college_gpa;
            $hscInsert->group_or_major =$request->college_group;
            $hscInsert->education_board =$request->college_board;
            $hscInsert->passing_year =$request->college_year;
            $hscInsert->save();

        }



    }

    public function updateHONS($request)
    {
        $tutor_id = $request->tutor_id;
        $honours = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'honours'])->first();
        if ($honours != null)
        {
            $honoursUpdate = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'honours'])->first();
            $honoursUpdate->institute_id = $request->graduation_university_id;
            $honoursUpdate->university_type =$request->graduation_university_type;
            $honoursUpdate->degree_name ='honours';
            $honoursUpdate->gpa =$request->graduation_university_cgpa;
            $honoursUpdate->department_id =$request->graduation_university_department_id;
            $honoursUpdate->study_type_id =$request->graduation_university_study_type_id;
            $honoursUpdate->passing_year =$request->graduation_university_passing_year;
            $honoursUpdate->save();


        }else
        {
            $honoursInsert = new TutorEducation();
            $honoursInsert->tutor_id = $tutor_id;
            $honoursInsert->institute_id = $request->graduation_university_id;
            $honoursInsert->university_type =$request->graduation_university_type;
            $honoursInsert->degree_name ='honours';
            $honoursInsert->gpa =$request->graduation_university_cgpa;
            $honoursInsert->department_id =$request->graduation_university_department_id;
            $honoursInsert->study_type_id =$request->graduation_university_study_type_id;
            $honoursInsert->passing_year =$request->graduation_university_passing_year;
            $honoursInsert->save();

        }


    }

    public function updateMasters($request)
    {
        $tutor_id = $request->tutor_id;
        $masters = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'masters'])->first();
        if ($masters != null)
        {
            $mastersUpdate = TutorEducation::where(['tutor_id'=>$tutor_id,'degree_name'=> 'masters'])->first();
            $mastersUpdate->institute_id = $request->post_graduation_university_id;
            $mastersUpdate->university_type =$request->post_graduation_university_type;
            $mastersUpdate->degree_name ='masters';
            $mastersUpdate->gpa =$request->post_graduation_university_cgpa;
            $mastersUpdate->department_id =$request->post_graduation_university_department_id;
            $mastersUpdate->study_type_id =$request->post_graduation_university_study_type_id;
            $mastersUpdate->passing_year =$request->post_graduation_university_passing_year;
            $mastersUpdate->save();


        }else
        {
            $mastersInsert = new TutorEducation();
            $mastersInsert->tutor_id = $tutor_id;
            $mastersInsert->institute_id = $request->post_graduation_university_id;
            $mastersInsert->university_type =$request->post_graduation_university_type;
            $mastersInsert->degree_name ='masters';
            $mastersInsert->gpa =$request->post_graduation_university_cgpa;
            $mastersInsert->department_id =$request->post_graduation_university_department_id;
            $mastersInsert->study_type_id =$request->post_graduation_university_study_type_id;
            $mastersInsert->passing_year =$request->post_graduation_university_passing_year;
            $mastersInsert->save();

        }


    }


}
