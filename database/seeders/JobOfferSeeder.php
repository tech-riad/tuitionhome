<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class jobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {

        $subject_id =  [
        0 => "60",
        1 => "61",
        2 => "63",
        3 => "67",
        4 => "69",
        ];

      $tutoring_category_id =[
      0 => "3"];
      $tutor_course_id = [
      0 => "13",
      1 => "15"
      ];
      $tutor_subject_id = [
      0 => "61",
      1 => "62",
      2 => "63"
      ];
      $tutor_university_id = [
      0 => "192"
      ];
      $tutor_study_type_id =[
      0 => "2"
      ];
      $tutor_department_id =[
      0 => "225",
      1 => "223"
      ];

        $job1=JobOffer::create([

            "parent_id" => "1",
        "student_name" => "test",
        "student_gender" => "male",
        "institute_name" => "tvschool",
        "category_id" => "3",
        "course_id" => "13",
        "days_in_week" => "4",
        "tutoring_time" => "12:33",
        "tutoring_duration" => "2",
        "teaching_method_id" => "2",
        "salary" => "10000",
        "number_of_students" => "1",
        "country_id" => "1",
        "city_id" => "1",
        "location_id" => "10",
        "full_address" => "mirpur, 2, sony",
        "tutor_requirement" => "abcd",
        "special_note" => "efgh",
        "staff_note" => "xyz",
        "tutor_religion" => "islam",
        "tutor_gender" => "male",
        "tutor_university_type" => "Public University",
        "year" => "2040",
        "tutor_school_id" => "616",
        "tutor_college_id" => "464",
        "tutor_board" => "jessore",
        "tutor_group" => "science",
        "tutor_curriculam_id" => "1",
        "date" => "2023-09-14",
        "is_sms_send" => "1",
        "created_by" => 1,
        "updated_at" => "2023-09-26 12:32:26",
        "created_at" => "2023-09-26 12:32:26",
           ]);

           $job2=JobOffer::create([

            "parent_id" => "1",
        "student_name" => "abc",
        "student_gender" => "male",
        "institute_name" => "danmondi high school",
        "category_id" => "4",
        "course_id" => "14",
        "days_in_week" => "5",
        "tutoring_time" => "12:33",
        "tutoring_duration" => "4",
        "teaching_method_id" => "3",
        "salary" => "15000",
        "number_of_students" => "1",
        "country_id" => "1",
        "city_id" => "1",
        "location_id" => "10",
        "full_address" => "mirpur, 2, sony",
        "tutor_requirement" => "abcd",
        "special_note" => "efgh",
        "staff_note" => "xyz",
        "tutor_religion" => "islam",
        "tutor_gender" => "male",
        "tutor_university_type" => "Public University",
        "year" => "2040",
        "tutor_school_id" => "616",
        "tutor_college_id" => "464",
        "tutor_board" => "jessore",
        "tutor_group" => "science",
        "tutor_curriculam_id" => "1",
        "date" => "2023-09-14",
        "is_sms_send" => "1",
        "created_by" => 1,
        "updated_at" => "2023-09-26 12:32:26",
        "created_at" => "2023-09-26 12:32:26",
           ]);

            $job1->job_offer_subject()->sync($subject_id);
            $job1->job_offer_tutor_categories()->sync($tutoring_category_id);
            $job1->job_offer_tutor_courses()->sync($tutor_course_id);
            $job1->job_offer_tutor_subjects()->sync($tutor_subject_id);
            $job1->job_offer_tutor_universities()->sync($tutor_university_id);
            $job1->job_offer_tutor_study_types()->sync($tutor_study_type_id);
            $job1->job_offer_tutor_departments()->sync($tutor_department_id);



            $job2->job_offer_subject()->sync($subject_id);
            $job2->job_offer_tutor_categories()->sync($tutoring_category_id);
            $job2->job_offer_tutor_courses()->sync($tutor_course_id);
            $job2->job_offer_tutor_subjects()->sync($tutor_subject_id);
            $job2->job_offer_tutor_universities()->sync($tutor_university_id);
            $job2->job_offer_tutor_study_types()->sync($tutor_study_type_id);
            $job2->job_offer_tutor_departments()->sync($tutor_department_id);

    }
}
