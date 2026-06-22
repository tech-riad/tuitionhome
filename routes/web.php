<?php
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\Blog\BlogCategoryController;
use App\Http\Controllers\Backend\CategoryTutorRequest\CategoryTutorRequestController;
use App\Http\Controllers\Backend\Blog\BlogPostsController;
use App\Http\Controllers\Backend\Blog\BlogTagsController;
use App\Http\Controllers\Backend\Blog\PostCommentController;
use App\Http\Controllers\Backend\Blog\PostReviewController;
use App\Http\Controllers\Backend\Config\CityController;
use App\Http\Controllers\Backend\Config\CountryController;
use App\Http\Controllers\Backend\Config\CoursesController;
use App\Http\Controllers\Backend\Config\CurriculaController;
use App\Http\Controllers\Backend\Config\DegreeController;
use App\Http\Controllers\Backend\Config\DepartmentController;
use App\Http\Controllers\Backend\Config\InstituteController;
use App\Http\Controllers\Backend\Config\LocationController;
use App\Http\Controllers\Backend\Config\StudyController;
use App\Http\Controllers\Backend\Config\SubjectController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\Setting\SettingController;
use App\Http\Controllers\Backend\VideoTutorialController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CourseSubjectController;
use App\Http\Controllers\Frontend\Tutor\TutorController;
use App\Http\Controllers\Frontend\Tutor\TutorDashboardController;
use App\Http\Controllers\Frontend\Tutor\TutorLoginController;
use App\Http\Controllers\Frontend\Tutor\TutorRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployeeController;
use App\Http\Controllers\Backend\Config\TutorRequirementTemplateController as ConfigTutorRequirementTemplateController;
use App\Http\Controllers\Backend\Parent\BackendParentController;
use App\Http\Controllers\Backend\PendingApproval\InstituteApproveController;
use App\Http\Controllers\Backend\Tutor\BackendTutorController;
use App\Http\Controllers\Backend\Tutor\InactiveTutorController;
use App\Http\Controllers\Backend\JobOffer\AddOfferController;
use App\Http\Controllers\Backend\JobOffer\AllJobOfferController;
use App\Http\Controllers\Backend\JobOffer\ApplicationJobOfferController;
use App\Http\Controllers\Backend\JobOffer\AvailableJobOfferController;
use App\Http\Controllers\Backend\Note\NoteController;
use App\Http\Controllers\Backend\Notice\NoticeController;
use App\Http\Controllers\Backend\Parent\BackendParentJobController;
use App\Http\Controllers\Backend\Sms\SendSmsController;
use App\Http\Controllers\Backend\Sms\SmsTamplateController;
use App\Http\Controllers\Backend\SmsTemplate\TemplateController;
use App\Http\Controllers\Backend\TakenOffer\TakenOfferController;
use App\Http\Controllers\Backend\Tutor\VerificationRequestController;
use App\Http\Controllers\CourseBlogPostController;
use App\Http\Controllers\Frontend\Api\Tutor\TutorController as TutorTutorController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\TutorRequirementTemplateController;
use App\Http\Controllers\WebleadController;
use App\Models\Backend\Config\TutorRequirementTemplate;
use App\Models\CourseBlogPost;
use App\Models\Tutor;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/example/dashboard',[HomeController::class,'dashboard']);
//Route::get('/',[TutorController::class,'index']);
// Route::any('/update-other-table', [TutorTutorController::class, 'updateOtherTable']);


//admin login route
Route::get('/admin/login',[AdminController::class,'login'])->name('admin.login');
Route::get('/fahmida-birthday',[AdminController::class,'fahHBD'])->name('fah.hbd');
Route::get('/fahmida-birthday-two',[AdminController::class,'fahHBDT'])->name('fah.hbdt');

//Employee login route
Route::get('/',[EmployeeController::class,'Emlogin'])->name('employee.login');
Route::post('/em-store',[EmployeeController::class,'EmCheckLogin'])->name('check.login');
Route::get('/employee/otp',[EmployeeController::class,'EmployeeOtp'])->name('employee.otp');
Route::post('/check/otp',[EmployeeController::class,'checkOtp'])->name('check.otp');
Route::get('/time',[EmployeeController::class,'timeset']);

//  For check Admin Phone is verified or not
Route::group(['middleware' => ['auth', 'phone.verified']], function () {

Route::get('/employee/home', [HomeController::class, 'index'])->name('employee.dashboard');
Route::any('/employee/logout', [EmployeeController::class, 'empLogout'])->name('employee.logout');


Route::get('/pdf/download',[PdfController::class,'generatePdf'])->name('pdf.index')->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home/institute', [HomeController::class, 'getInstitutes'])->middleware('auth');
Route::get('/setting/institute-change', [HomeController::class, 'instituteChange'])->name('institute.change')->middleware('auth');;
Route::post('/home/update-institute', [HomeController::class, 'updateInstitute'])->middleware('auth');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {
    Route::resource('users',AdminUserController::class);
    Route::resource('roles', RolesController::class)->except(['index', 'create', 'store', 'edit', 'update', 'destroy', 'show']);


    Route::get('roles', [RolesController::class, 'index'])->name('roles.index')->middleware('permission:role-index');
    Route::get('roles/create', [RolesController::class, 'create'])->name('roles.create')->middleware('permission:role-create');
    Route::post('roles', [RolesController::class, 'store'])->name('roles.store')->middleware('permission:role-store');
    Route::get('roles/{role}', [RolesController::class, 'show'])->name('roles.show')->middleware('permission:role-show');
    Route::get('roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit')->middleware('permission:role-edit');
    Route::put('roles/{role}', [RolesController::class, 'update'])->name('roles.update')->middleware('permission:role-edit');
    Route::delete('roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy')->middleware('permission:role-delete');

    Route::get('/user-activity',[AdminUserController::class,'userActivity'])->name('user.activity')->middleware('auth');
    Route::any('/user-password-change',[AdminUserController::class,'userChangePassword'])->name('user.change.password')->middleware('auth');

    Route::post('/permission/store',[RolesController::class,'permissionStore'])->name('permission.store');
    Route::get('/permission/index',[RolesController::class,'permissionList'])->name('permission.index');
    Route::post('/permission/update',[RolesController::class,'permissionUpdate'])->name('permission.update');
    Route::post('/permission/destroy/{id}',[RolesController::class,'permissionDelete'])->name('permission.destroy');
    Route::post('/user/update',[AdminUserController::class,'update'])->name('user.update');
    Route::post('/user/delete/{id}',[AdminUserController::class,'destroy'])->name('user.delete');
    Route::get('/user/view/{id}',[AdminUserController::class,'show'])->name('user.view');
//    config route
    Route::get('config/country/index',[CountryController::class,'index'])->name('config.country.index');
    Route::post('config/country/store',[CountryController::class,'store'])->name('config.country.store');
    Route::get('config/country/edit/{id}',[CountryController::class,'edit'])->name('config.country.edit');
    Route::post('config/country/update/{id}',[CountryController::class,'update'])->name('config.country.update');
    Route::get('config/country/delete/{id}',[CountryController::class,'delete'])->name('config.country.delete');
//    import country route
   Route::post('config/country/import',[CountryController::class,'importCountry'])->name('config.country.import.store');
//    import City route
   Route::post('config/city/import',[CityController::class,'importCountry'])->name('config.city.import.store');
//    import Locations route
   Route::post('config/location/import',[LocationController::class,'importLocation'])->name('config.location.import.store');
//    import Category route
   Route::post('config/category/import',[CategoriesController::class,'importCategory'])->name('config.category.import.store');
//    import Course route
   Route::post('config/course/import',[CoursesController::class,'importCourse'])->name('config.course.import.store');
//    import Curriculam route
   Route::post('config/curricula/import',[CurriculaController::class,'importCurricula'])->name('config.curricula.import.store');
//    import Degrees route
   Route::post('config/degree/import',[DegreeController::class,'importDegree'])->name('config.degree.import.store');
//    import Study route
   Route::post('config/study/import',[StudyController::class,'importStudy'])->name('config.study.import.store');
//    import Department route
   Route::post('config/department/import',[DepartmentController::class,'importDepartment'])->name('config.department.import.store');
//    import Subjects route
   Route::post('config/subject/import',[SubjectController::class,'importSubject'])->name('config.subject.import.store');
//    import Institute route
   Route::post('config/institute/import',[InstituteController::class,'importInstitute'])->name('config.institute.import.store');
//    import course subjects route
   Route::post('config/coursesubjects/import/store',[CourseSubjectController::class,'importCourseSubject'])->name('config.coursesubjects.import.store');
//    Tutor Requirement Table
Route::get('config/requirement/template',[ConfigTutorRequirementTemplateController::class,'index'])->name('config.requirement.template');
Route::get('config/requirement/template/create',[ConfigTutorRequirementTemplateController::class,'create'])->name('config.requirement.template.create');
Route::post('config/requirement/template/store',[ConfigTutorRequirementTemplateController::class,'store'])->name('config.requirement.template.store');
Route::get('config/requirement/template/edit/{id}',[ConfigTutorRequirementTemplateController::class,'edit'])->name('config.requirement.template.edit');
Route::post('config/requirement/template/update/{id}',[ConfigTutorRequirementTemplateController::class,'update'])->name('config.requirement.template.update');
Route::any('config/requirement/template/delete/{id}',[ConfigTutorRequirementTemplateController::class,'destroy'])->name('config.requirement.template.delete');


});



//...................config file start route here................
Route::resource('cities', CityController::class);
Route::resource('locations', LocationController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('courses', CoursesController::class);
Route::resource('curriculas', CurriculaController::class);
Route::resource('degrees', DegreeController::class);
Route::resource('studies', StudyController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('institutes', InstituteController::class);
// Route::post('/search', 'InstituteController@search');
Route::post('/search',[InstituteController::class,'search'])->name('search');
Route::any('/location/search',[LocationController::class,'locationSearch'])->name('locationSearch');
Route::get('course_subject/index',[CourseSubjectController::class,'index'])->name('course_subject.index');
Route::get('course_subject/create',[CourseSubjectController::class,'create'])->name('course_subject.create');
Route::post('course_subject/store',[CourseSubjectController::class,'store'])->name('course_subject.store');
Route::get('course_subject/edit/{id}',[CourseSubjectController::class,'edit'])->name('course_subject.edit');
Route::get('course_subject/delete/{id}',[CourseSubjectController::class,'delete'])->name('course_subject.delete');
Route::post('course_subject/update/{id}',[CourseSubjectController::class,'update'])->name('course_subject.update');
//...................config file End route here................
Route::any('/categories/search',[CategoriesController::class,'categoriesSearch'])->name('categoriesSearch');
Route::any('/courses/search',[CoursesController::class,'coursesSearch'])->name('coursesSearch');
Route::any('/subjects/search',[SubjectController::class,'subjectsSearch'])->name('subjectsSearch');
Route::any('/course_subject/search',[CourseSubjectController::class,'courseSubjectsSearch'])->name('courseSubjectsSearch');
Route::any('/departments/search',[DepartmentController::class,'departmentsSearch'])->name('departmentsSearch');
Route::any('/cities/search',[CityController::class,'citiesSearch'])->name('citiesSearch');

// Tutorial Route
Route::resource('admin/tutorial', VideoTutorialController::class)->middleware('permission:video-tutorial');
Route::get('/admin/tutorial/trash',[VideoTutorialController::class,'trash'])->name('tutorial.trash')->middleware('permission:video-tutorial');
Route::get('/admin/tutorial/{tutorial}/restore',[VideoTutorialController::class,'restore'])->name('tutorial.restore')->middleware('permission:tutorial-restore');
Route::delete('/admin/tutorial/{tutorial}/delete',[VideoTutorialController::class,'delete'])->name('tutorial.delete')->middleware('permission:tutorial-delete');
Route::post('/admin/video/tutorial/update',[VideoTutorialController::class,'update'])->name('video-tutorial.update')->middleware('permission:tutorial-update');

//tutor route
Route::prefix('tutor')->name('tutor.')->group(function (){

        Route::get('tutor/login',[TutorRegisterController::class,'TutorLogin'])->name('login');
        Route::post('tutor/check',[TutorLoginController::class,'TutorLoginCheck'])->name('login.check');
        Route::get('tutor/register',[TutorRegisterController::class,'TutorRegister'])->name('register');
        Route::post('tutor/register/store',[TutorRegisterController::class,'TutorRegisterStore'])->name('register.store');

    Route::middleware('tutor')->group(function (){
        Route::get('/dashboard',[TutorDashboardController::class,'index'])->name('dashboard');
        Route::get('/personal/info',[TutorController::class,'index'])->name('personal.info');
        Route::post('/personal/info/store',[TutorController::class,'store'])->name('personal.info.store');
        Route::get('/tutor/update',[TutorDashboardController::class,'profileUpdateView'])->name('profile.update');
        Route::post('/tutoring_info/save',[TutorController::class,'tutoring_info'])->name('tutoring_info.save');
        Route::get('/education_info',[TutorController::class,'education_info'])->name('education_info');
        Route::post('/tutoreducation_info/save',[TutorController::class,'tutoreducation_info'])->name('tutoreducation_info.save');
        Route::get('/personal_info',[TutorController::class,'personal_info'])->name('personal_info');
        Route::post('/personal/info/save',[TutorController::class,'personal_info_save'])->name('personal_info_save');
        Route::get('/crediantial',[TutorController::class,'crediantial'])->name('crediantial');
        Route::post('/crediantial/store',[TutorController::class,'crediantial_store'])->name('crediantial.store');



//        view tutor profile route
        Route::get('/profile-view',[TutorController::class,'viewProfile'])->name('profile-view');
//      End  view tutor profile route
        Route::post('/tutor/logout',[TutorLoginController::class,'logout'])->name('logout');
    });
    Route::get('/otp',[OtpVerificationController::class,'otp'])->name('otp');
    Route::post('/otp-verify',[OtpVerificationController::class,'verifyOtp'])->name('otp.verify');
    Route::post('/otp-resend',[OtpVerificationController::class,'resendOtp'])->name('otp.resend');
});

//Crop Image route

Route::post('/crop-certificate',[TutorController::class,'cropCertificate'])->name('crop-certificate');
Route::post('/tutor/crop-profile-image',[TutorController::class,'profilePic'])->name('crop-profile-image');

Route::get('/personal',[TutorController::class,'index']);
//country city location route
Route::post('get_city',[CityController::class,'getCity'])->name('get_city');
Route::post('get_location',[LocationController::class,'getLocation'])->name('get_location');
//get category course route
Route::post('get_class_course',[CoursesController::class,'get_class_course'])->name('get_class_course');
Route::any('get_course_subject',[CourseSubjectController::class,'get_course_subject'])->name('get_course_subject');
// Route::post('get_additional_class_course',[CourseSubjectController::class,'get_additional_class_course'])->name('get_additional_class_course');
// Route::post('get_additional_course_subject',[CourseSubjectController::class,'get_additional_course_subject'])->name('get_additional_course_subject');
// Sidebar menu route
// Tutor job-board route
Route::get('/tutor/jobs-board',[TutorController::class,'jobBoard'])->name('tutor.jobs-board');
// Tutor payment route
Route::get('/tutor/payment',[TutorController::class,'payment'])->name('tutor.payment');
//confirmation letter route
Route::get('/tutor/confirmation',[TutorController::class,'confirmation'])->name('tutor.confirmation');
//memberships route
Route::get('/tutor/membership',[TutorController::class,'membership'])->name('tutor.membership');
//Tutor Setting route
Route::get('/tutor/Setting',[TutorController::class,'setting'])->name('tutor.Setting');
// Tutor Notification
Route::get('/tutor/notification',[TutorController::class,'notification'])->name('tutor.notification');
// Tutor Account Status
Route::get('/tutor/status',[TutorController::class,'accountStatus'])->name('tutor.status');
// Tutor Change password
Route::get('/tutor/change/password',[TutorController::class,'changePassword'])->name('tutor.change-password');
Route::post('/tutor/change-password',[TutorController::class,'change_password'])->name('tutor.change.password');
// Tutor de-activate account
Route::get('/tutor/account/deactivate',[TutorController::class,'accountDeactivate'])->name('tutor.account-deactivate');

//change tutor email
Route::post('/change/email',[TutorController::class,'changeEmail'])->name('change.email');
Route::get('/email/verification/code',[TutorController::class,'emailVerification'])->name('email-verification-code');
Route::post('/email/verified',[TutorController::class,'emailVerified'])->name('verified.email');
//change tutor phone
Route::post('/change/phone',[TutorController::class,'changePhone'])->name('change.phone');
//change tutor Name
Route::post('/change/name',[TutorController::class,'changeName'])->name('change.name');

//tutor deactivate account route
Route::post('/tutor/account/deactive',[TutorController::class,'deactivateAccount'])->name('tutor.account.deactive');


Route::get('/admin/setting/index',[SettingController::class,'index'])->name('setting.index');
Route::any('/admin/setting/converted/tutor/parent',[SettingController::class,'convertParentIndex'])->name('admin.converted.parent');
Route::post('/admin/setting/convert/tutor-parent',[SettingController::class,'convertTutorParent'])->name('admin.convert.tutor.parent');
Route::get('/admin/setting/demo',[SettingController::class,'demo'])->name('setting.demo');
Route::get('/admin/setting/website-setting',[SettingController::class,'websiteSetting'])->name('website.setting');
Route::post('/admin/payment/setpoint/add', [SettingController::class, 'paymentSetPoint'])->name('website.payment.setpoint');
Route::get('/admin/setting/sms-setting',[SettingController::class,'smsSetting'])->name('sms.setting');
Route::get('/admin/setting/reference-table-setting',[SettingController::class,'ReferenceTableSetting'])->name('reference.table.setting');
Route::get('/admin/setting/web-mail',[SettingController::class,'webMail'])->name('web.mail');
Route::get('/admin/setting/web-mail',[SettingController::class,'webMail'])->name('web.mail');


Route::get('/admin/blog/category',[BlogCategoryController::class,'index'])->name('blog.category');
Route::post('/admin/blog/category/store',[BlogCategoryController::class,'store'])->name('blog.category.store');
Route::delete('/admin/blog/category/{category}/delete',[BlogCategoryController::class,'delete'])->name('blog.category.delete');
Route::get('/admin/blog/category/edit/{category}',[BlogCategoryController::class,'edit'])->name('blog.category.edit');
Route::post('/admin/blog/category/update',[BlogCategoryController::class,'update'])->name('blog.category.update');


Route::get('/admin/blog/tag/index',[BlogTagsController::class,'index'])->name('blog.tag.index');
Route::Post('/admin/blog/tag/store',[BlogTagsController::class,'store'])->name('blog.tag.store');
Route::delete('/admin/blog/tag/{tag}/delete',[BlogTagsController::class,'delete'])->name('blog.tag.delete');
Route::get('/admin/blog/tag/edit/{tag}',[BlogTagsController::class,'edit'])->name('blog.tag.edit');
Route::post('/admin/blog/tag/update',[BlogTagsController::class,'update'])->name('blog.tag.update');


Route::get('/admin/blog/posts',[BlogPostsController::class,'index'])->name('blog.posts');
Route::get('/admin/blog/post/create',[BlogPostsController::class,'create'])->name('post.create');
Route::post('/admin/blog/post/store',[BlogPostsController::class,'store'])->name('post.store');
Route::get('/admin/blog/post/{post}/show',[BlogPostsController::class,'show'])->name('post.show');
Route::get('/admin/blog/post/{post}/edit',[BlogPostsController::class,'edit'])->name('post.edit');
Route::post('/admin/blog/post/{post}/update',[BlogPostsController::class,'update'])->name('post.update');
Route::delete('/admin/blog/post/{post}/delete',[BlogPostsController::class,'delete'])->name('post.delete');


Route::get('/admin/blog/reviews',[PostReviewController::class,'index'])->name('blog.reviews');

Route::post('/blog/message/store',[PostCommentController::class,'store'])->name('blog.message.store');
Route::get('/admin/blog/comments',[PostCommentController::class,'index'])->name('blog.comment.index');
Route::delete('/admin/blog/comment/{comment}/delete',[PostCommentController::class,'delete'])->name('blog.comment.delete');

Route::get('/blog',[BlogController::class,'index'])->name('blog.index');
Route::get('/blog/{post}/details',[BlogController::class,'show'])->name('blog.details');



Auth::routes([
    'register' => false,
]);

// Route::get('/admin/parent/index',[ParentController::class,'index'])->name('parent.index');
Route::resource('admin/parent', BackendParentController::class)->except(['show']);

Route::post('/admin/parent/Verify-phone',[BackendParentController::class,'VerifyPhone'])->name('admin.parent.verify-phone');
Route::post('/admin/parent/sms/editor',[BackendParentController::class,'smsEditor'])->name('admin.parent.sms-editor');
Route::post('/admin/parent/send-sms',[BackendParentController::class,'sendSms'])->name('admin.parent.send-sms');
Route::get('/admin/parent/{parent}/send-sms',[BackendParentController::class,'singleSms'])->name('admin.parent.single-sms');
Route::post('/admin/parent/search',[BackendParentController::class,'search'])->name('admin.parent.search');
Route::get('/admin/parent/sms',[BackendParentController::class,'smsOnOff'])->name('admin.parent.smsOnOff');

Route::post('/admin/parent/note',[BackendParentController::class,'parentNote'])->name('admin.parent.note');

Route::get('/admin/parent/{parent}/show',[BackendParentController::class,'show'])->name('admin.parent.show');

Route::get('/admin/parent/get/note',[BackendParentController::class,'getNote'])->name('admin.parent.getnote');


Route::resource('admin/tutor', BackendTutorController::class)->except(['show'])->middleware('permission:tutor-page');
Route::post('/update-tutor-status/{id}',[BackendTutorController::class,'updateStatus'])->name('update-tutor-status');

// Route::get('/admin/tutor/paginate', [BackendTutorController::class, 'paginateInput']);


Route::any('/admin/tutor/paginate',[BackendTutorController::class,'paginateInput'])->name('admin.tutor.paginate')->middleware('permission:tutor-page');
Route::post('/admin/tutor/Verify-phone',[BackendTutorController::class,'VerifyPhone'])->name('admin.tutor.verify-phone')->middleware('permission:tutor-edit');
Route::any('/admin/tutor/sms/editor',[BackendTutorController::class,'smsEditor'])->name('admin.tutor.sms-editor')->middleware('permission:tutor-page');
Route::any('/admin/tutor/send-sms',[BackendTutorController::class,'sendSms'])->name('admin.tutor.send-sms')->middleware('permission:tutor-page');
Route::any('/admin/tutor/{tutor}/send-sms',[BackendTutorController::class,'singleSms'])->name('admin.tutor.single-sms')->middleware('permission:tutor-page');
Route::post('/admin/tutor/sms/status',[BackendTutorController::class,'changeStatus'])->name('admin.tutor.sms.status')->middleware('permission:tutor-page');
Route::get('/admin/tutor/delete/note/{id}', [BackendTutorController::class, 'tutorDeleteNoteList'])->name('admin.tutor.delete.note')->middleware('permission:tutor-page');




Route::get('/admin/tutor/get-tutor/{tutor}',[BackendTutorController::class,'showTutor'])->name('admin.tutor.tutorshow')->middleware('permission:tutor-show');
Route::post('/admin/tutor/update/{tutor}',[BackendTutorController::class,'tutorUpdate'])->name('admin.tutor.update')->middleware('permission:tutor-edit');
Route::post('/admin/tutor/search',[BackendTutorController::class,'search'])->name('admin.tutor.search')->middleware('permission:tutor-page');
Route::any('/admin/premium/tutors',[BackendTutorController::class,'premiumTutor'])->name('admin.tutor.premium')->middleware('permission:tutor-page');
Route::any('/admin/member/count',[BackendTutorController::class,'memberCount'])->name('admin.tutor.member.count')->middleware('permission:tutor-page');
Route::any('/admin/verified/tutors',[BackendTutorController::class,'verifiedTutor'])->name('admin.tutor.verified')->middleware('permission:tutor-page');
Route::get('/admin/featured/tutors',[BackendTutorController::class,'featuredTutor'])->name('admin.tutor.featured')->middleware('permission:tutor-page');
Route::get('/admin/boost/tutors',[BackendTutorController::class,'boostTutor'])->name('admin.boost.featured')->middleware('permission:tutor-page');
Route::post('/admin/tutors/make-premium',[BackendTutorController::class,'makePremium'])->name('tutor.make.premium')->middleware('permission:tutor-premium');
Route::post('/admin/tutors/make-alert/{tutor}',[BackendTutorController::class,'makeAlert'])->name('tutor.make.alert')->middleware('permission:tutor-alert');
Route::post('/admin/tutors/undo-alert/{tutor}',[BackendTutorController::class,'undoAlert'])->name('tutor.undo.alert')->middleware('permission:tutor-alert');

Route::post('/admin/tutors/undo-premium/{tutor}',[BackendTutorController::class,'undoPremium'])->name('tutor.undo.premium')->middleware('permission:tutor-premium');

Route::post('/admin/tutors/make-featured/{tutor}',[BackendTutorController::class,'makefeatured'])->name('tutor.make.featured')->middleware('permission:tutor-featured');

Route::post('/admin/tutors/undo-featured/{tutor}',[BackendTutorController::class,'undofeatured'])->name('tutor.undo.featured')->middleware('permission:tutor-featured');

Route::post('/admin/tutors/verify/{tutor}',[BackendTutorController::class,'verifyTutor'])->name('admin.tutor.verify')->middleware('permission:tutor-verify');
Route::post('/admin/tutors/boost/{tutor}',[BackendTutorController::class,'makeTutorBoost'])->name('admin.tutor.boost');

Route::get('/admin/tutors/trash',[BackendTutorController::class,'trash'])->name('admin.tutors.trash')->middleware('permission:tutor-trash-page');
Route::any('/admin/tutor/{tutor}/restore',[BackendTutorController::class,'restore'])->name('admin.tutor.restore')->middleware('permission:tutor-restore');
Route::delete('/admin/tutor/{tutor}/delete',[BackendTutorController::class,'delete'])->name('admin.tutor.delete')->middleware('permission:tutor-delete');
// Route::get('/admin/tutor/{tutor}/note',[BackendTutorController::class,'note'])->name('admin.tutor.note');
Route::post('/admin/tutor/note/create',[BackendTutorController::class,'createNote'])->name('admin.tutor.note-create')->middleware('permission:tutor-trash-page');

Route::post('/admin/tutor/note/add',[BackendTutorController::class,'tutorNote'])->name('admin.tutor.note')->middleware('permission:tutor-trash-page');

Route::get('/admin/note/tutor/get',[BackendTutorController::class,'getNote'])->name('admin.tutor.getnote')->middleware('permission:tutor-trash-page');



Route::get('/admin/tutor/edit-info/{tutor}',[BackendTutorController::class,'editInfo'])->name('admin.tutor.edit-info')->middleware('permission:edit-info');

Route::Post('/admin/tutor/edit-tutoring-info',[BackendTutorController::class,'updateTutoringInfo'])->name('admin.tutor.updateTutoringInfo')->middleware('permission:edit-info');

Route::Post('/admin/tutor/edit-personal-info',[BackendTutorController::class,'updatePersonalInfo'])->name('admin.tutor.updatePersonalInfo')->middleware('permission:edit-info');

Route::Post('/admin/tutor/edit-educational-info',[BackendTutorController::class,'updateEducationalInfo'])->name('admin.tutor.updateEducationalInfo')->middleware('permission:edit-info');

Route::Post('/admin/tutor/update-certificate-file',[BackendTutorController::class,'updateCertificateFile'])->name('admin.tutor.updateCertificateFile')->middleware('permission:edit-info');

Route::get('/admin/{tutor}/cv-pdf',[BackendTutorController::class,'cvPdf'])->name('admin.tutor.cv-pdf')->middleware('permission:tutor-page');

Route::any('/admin/filter/tutor',[BackendTutorController::class,'filter'])->name('admin.tutor.filter')->middleware('permission:tutor-page');
Route::any('/admin/filter/trash-tutor',[BackendTutorController::class,'filterTrashTutor'])->name('admin.tutor.filter.trash.tutor')->middleware('permission:tutor-page');
// Route::get('/admin/tutor/edit-info2',[BackendTutorController::class,'editInfo'])->name('admin.tutor.edit-info2');





Route::get('/admin/approve/institute/index',[InstituteApproveController::class,'index'])->name('admin.approve.institute');
Route::get('/admin/approve/{institute}/edit',[InstituteApproveController::class,'edit'])->name('admin.approve.institute.edit');
Route::delete('/admin/approve/{institute}/delete',[InstituteApproveController::class,'delete'])->name('admin.approve.institute.delete');
Route::post('/admin/approve/institute/update',[InstituteApproveController::class,'update'])->name('admin.approve.institute.update');
Route::post('/admin/approve/{institute}/approve',[InstituteApproveController::class,'approve'])->name('admin.approve.institute.approve');
Route::get('/admin/institute/search',[InstituteApproveController::class,'search'])->name('admin.institute.search');
Route::get('/admin/institute/include',[InstituteApproveController::class,'includeUnderOldInstitute'])->name('admin.institute.include');

// Job Offer Route Group

Route::middleware(['auth'])->group(function () {
    Route::post('/admin/add-parent',[AddOfferController::class,'AddNewParent'])->name('admin.add-new-parent');
    Route::post('/admin/add-reference',[AddOfferController::class,'AddNewReference'])->name('admin.add-new-reference');
    Route::get('/admin/job-offer/parents-search',[AddOfferController::class, 'searchParent'])->name('parentSearch');
    Route::get('/admin/job-offer/reference-search',[AddOfferController::class, 'searchReference'])->name('reference_search');

    Route::get('/admin/job-offer/application-offer',[ApplicationJobOfferController::class,'index'])->name('admin.job-offer.application-offers')->middleware('permission:applications');
    Route::get('/admin/job/edit/{id}',[AllJobOfferController::class,'edit'])->name('admin.job.edit')->middleware('permission:job-offer-edit');
    Route::any('/admin/job/update',[AllJobOfferController::class,'update'])->name('admin.job.update')->middleware('permission:job-offer-update');
    Route::get('/admin/job/see-condition/{id?}',[AllJobOfferController::class,'seeCondition'])->name('admin.job.see-condition')->middleware('permission:job-offer-see-condition');
    Route::post('/admin/job/update-additional-child',[AllJobOfferController::class,'additionalChildUpdate'])->name('admin.job.additional-child-update')->middleware('permission:additional-child-update');

    // Job Offer Sms Send
    Route::any('/admin/parent/sms/editor',[AllJobOfferController::class,'smsEditor'])->name('admin.parent.sms-editor');


    Route::post('/admin/add-additional-child',[AddOfferController::class,'AddAdditionalChild'])->name('admin.add-additional-child')->middleware('permission:aditional-child-add');
    Route::get('/admin/job-details/{job}',[AllJobOfferController::class,'jobDetails'])->name('admin.job-details');
    Route::get('/admin/job-counting',[AllJobOfferController::class,'jobCounting'])->name('admin.job-count');


    Route::any('/admin/job/search-tutor',[AllJobOfferController::class,'searchTutor'])->name('admin.job.search-tutor');
    Route::any('/admin/job/search',[AllJobOfferController::class,'jobSearch'])->name('admin.job.search');
    Route::any('/admin/job/search-single-available',[AllJobOfferController::class,'jobSearchSingleAvailable'])->name('admin.job.search-single-available');
    Route::any('/admin/job/search-single-all',[AllJobOfferController::class,'jobSearchSingleAll'])->name('admin.job.search-single-all');
    Route::get('/admin/job-offer/all-offer', [AllJobOfferController::class, 'index'])->middleware('permission:all-offer')->name('admin.job-offer.all-offers');
    Route::get('/admin/job-offer/schedule-offer', [AllJobOfferController::class, 'scheduleOffer'])->middleware('permission:all-offer')->name('admin.job-offer.schedule-offers');
    Route::post('/admin/job-offer/store',[AddOfferController::class,'store'])->name('admin.job-offer.store')->middleware('permission:store-offer');
    Route::get('/admin/job-offer',[AddOfferController::class,'index'])->name('admin.job-offer.index')->middleware('permission:add-offer');
    Route::get('/admin/job-offer/available-offer', [AvailableJobOfferController::class, 'index'])->middleware('permission:available-offer')->name('admin.job-offer.available-offers');
    Route::post('/admin/sms/limit',[AllJobOfferController::class,'smsLimit'])->name('admin.sms.limit')->middleware('permission:sms-limit');
    Route::post('/admin/job-offer/status',[AllJobOfferController::class,'changeStatus'])->name('admin.job_offers.status');
    Route::any('/admin/job/reset-condition/{id}',[AllJobOfferController::class,'restoreCondition'])->name('admin.job.restore-condition')->middleware('permission:see-condition-restore');


    Route::get('/admin/job/sms-log/{job}',[AllJobOfferController::class,'smsLog'])->name('admin.job.sms-log');
    Route::get('/admin/job/status-log/{id}',[AllJobOfferController::class,'statusLog'])->name('admin.job.status-log')->middleware('permission:job-status-log');

    // admin
    Route::any('/admin/job/sms/delete',[AllJobOfferController::class,'jobSmsDelete'])->name('admin.job.sms.delete')->middleware('permission:job-sms-delete');
    Route::get('/admin/job/sms-view/{id}',[AllJobOfferController::class,'SmsView'])->name('admin.job.sms-view')->middleware('permission:job-sms-view');
    Route::get('/admin/job/edit-history/view-details/{id}',[AllJobOfferController::class,'editHistoryDetails'])->name('admin.job.edit-history.view-details')->middleware('permission:job-history-view');
    Route::get('/admin/job/log-history/view-details/{id}',[AllJobOfferController::class,'jobLogDetails'])->name('admin.job.jobLogDetails')->middleware('permission:job-edit-log');



    // job offer application list route
    Route::get('/admin/job/applicant-list/{id}',[ApplicationJobOfferController::class,'applicantList'])->name('admin.job.applicant-list')->middleware('permission:applicant-list');
    Route::any('/admin/job/applicant-list-restore/{id}',[ApplicationJobOfferController::class,'applicantListRestore'])->name('admin.job.applicant-list.restore')->middleware('permission:applicant-restore');
    Route::post('/admin/job_offers/application-take',[ApplicationJobOfferController::class,'jobTaken'])->name('admin.job_offers.application-take')->middleware('permission:applicant-take');
    Route::post('/admin/job_offers/application-shortlist',[ApplicationJobOfferController::class,'jobShortlist'])->name('admin.job_offers.application-shortlist')->middleware('permission:applicant-shortlist');
    Route::get('/admin/application/seen/tutor',[TakenOfferController::class,'seenApplication'])->name('admin.application.seen.tutor')->middleware('permission:applicant-seen');


    Route::post('/admin/applied_tutor/note',[NoteController::class,'applliedNote'])->name('admin.applied_tutor.note');
    Route::post('/admin/applied_tutor/note/get',[NoteController::class,'getApplliedNote'])->name('admin.applied_tutor.note.get');
    Route::post('/admin/applied_tutor/note/log',[NoteController::class,'getApplliedNoteLog'])->name('admin.applied_tutor.note.log');
    Route::post('/admin/applied_tutor/delete',[ApplicationJobOfferController::class,'AppliedTutorDelete'])->name('admin.applied_tutor.delete');
    Route::post('/admin/new/tutor/assign',[ApplicationJobOfferController::class,'newAssignTutor'])->name('admin.new.tutor.assign');
    Route::post('/admin/tutor/job/apply',[ApplicationJobOfferController::class,'jobApply'])->name('admin.tutor.job.apply');

    Route::post('/admin/application/list/bulksms',[SendSmsController::class,'applicantSend'])->name('admin.application.list.bulksms')->middleware('permission:bulk-sms-send');


});



// all offer route
Route::any('/admin/model/role/setup',[SettingController::class,'modelRoleSetup'])->name('admin.model.role.setup');
// Available offer route

// Application offer route

// applied jobOffer sms send route




Route::get('/admin/sms/index',[SmsTamplateController::class,'index'])->name('admin.sms.index')->middleware('permission:bulk-sms-template');
Route::any('/admin/sms/search',[SmsTamplateController::class,'searchSms'])->name('admin.sms.search')->middleware('permission:bulk-sms-template');

Route::post('/admin/sms/store',[SmsTamplateController::class,'store'])->name('admin.sms.store')->middleware('permission:bulk-sms-action');

Route::get('/admin/sms/edit',[SmsTamplateController::class,'edit'])->name('admin.sms.edit')->middleware('permission:bulk-sms-action');

Route::post('/admin/sms/update',[SmsTamplateController::class,'update'])->name('admin.sms.update')->middleware('permission:bulk-sms-action');

Route::post('/admin/sms/{sms}/delete',[SmsTamplateController::class,'delete'])->name('admin.sms.delete')->middleware('permission:bulk-sms-action');

Route::get('/admin/bulk-sms',[SmsTamplateController::class,'bulkSms'])->name('admin.bulk-sms')->middleware('permission:send-bulk-sms');

Route::get('/admin/sms/template/change',[SmsTamplateController::class,'TemChange'])->name('admin.template.change');

Route::any('/admin/bulk/sms/send',[SmsTamplateController::class,'smsSend'])->name('admin.bulk.sms.send')->middleware('permission:send-bulk-sms');
Route::get('/admin/sms/log/index',[SmsTamplateController::class,'smsLog'])->name('admin.sms.log')->middleware('permission:sms-logs');
Route::post('/admin/sms/log/{log}/delete',[SmsTamplateController::class,'smsLogDelete'])->name('admin.sms.log.delete')->middleware('permission:sms-logs-actions');
Route::get('/admin/sms/log/{log}/show',[SmsTamplateController::class,'showSmsLog'])->name('admin.show.sms.log')->middleware('permission:sms-logs-actions');
Route::post('/admin/sms/log/filter',[SmsTamplateController::class,'filter'])->name('admin.sms.log.filter')->middleware('permission:sms-logs-actions');
Route::post('/admin/sms/resend-sms',[SmsTamplateController::class,'resendSms'])->name('admin.resend.sms')->middleware('permission:send-bulk-sms');

Route::get('/admin/sms_templates/index',[TemplateController::class,'index'])->name('admin.sms_template.index')->middleware('permission:sms-templates');
Route::post('/admin/sms_template/store',[TemplateController::class,'store'])->name('admin.sms_template.store')->middleware('permission:sms-template-actions');
Route::get('/admin/sms_template/edit',[TemplateController::class,'edit'])->name('admin.sms_template.edit')->middleware('permission:sms-template-actions');
Route::post('/admin/sms_template/update',[TemplateController::class,'update'])->name('admin.sms_template.update')->middleware('permission:sms-template-actions');
Route::post('/admin/sms_template/{template}/delete',[TemplateController::class,'delete'])->name('admin.sms_template.delete')->middleware('permission:sms-template-actions');
Route::get('/admin/sms_template/{template}/show',[TemplateController::class,'show'])->name('admin.sms_template.show')->middleware('permission:sms-template-actions');

Route::post('/admin/job/tutor/sms',[AllJobOfferController::class,'tutorSms'])->name('admin.job.tutor.sms');
Route::any('/admin/job/tutor/resend-sms',[AllJobOfferController::class,'resendSms'])->name('admin.job.tutor.resend.sms');

Route::any('/admin/job/tutor/sms/send',[AllJobOfferController::class,'tutorSmsSend'])->name('admin.job.tutor.sms.send');

Route::get('/admin/job/sms_template/change',[AllJobOfferController::class,'TemChange'])->name('admin.job.sms_template.change');

// Route::get('/admin/taken-offer/index',[TakenOfferController::class,'index'])->name('admin.taken_offer.index');

Route::get('/admin/taken-offer/index',[TakenOfferController::class,'index'])->name('admin.taken_offer.index');
Route::get('/admin/taken-offer/{application}/manage',[TakenOfferController::class,'manageApplication'])->name('admin.taken_offer.manage');


Route::post('/admin/job-application/note/add',[TakenOfferController::class,'setNote'])->name('admin.application.setnote');

Route::get('/admin/job-application/note/get',[TakenOfferController::class,'getNote'])->name('admin.application.getnote');


Route::post('/admin/application/stage/change',[TakenOfferController::class,'waitingStageChange'])->name('admin.application.stage.change')->middleware('permission:stage-change');

Route::post('/admin/application/stage/change/meeting',[TakenOfferController::class,'meetingStageChange'])->name('admin.application.stage.meeting')->middleware('permission:stage-change');

Route::post('/admin/application/stage/change/trial',[TakenOfferController::class,'trialStageChange'])->name('admin.application.stage.trial')->middleware('permission:stage-change');
Route::post('/admin/application/stage/change/problem',[TakenOfferController::class,'problemStageChange'])->name('admin.application.stage.problem')->middleware('permission:stage-change');
Route::post('/admin/application/stage/change/closed',[TakenOfferController::class,'closedStageChange'])->name('admin.application.stage.closed')->middleware('permission:stage-change');
Route::post('/admin/application/stage/change/confirm',[TakenOfferController::class,'confirmStageChange'])->name('admin.application.stage.confirm')->middleware('permission:stage-change');
Route::post('/admin/application/stage/change/repost',[TakenOfferController::class,'repostStageChange'])->name('admin.application.stage.repost')->middleware('permission:stage-change');

Route::post('/admin/application/assign/search',[TakenOfferController::class,'assignSearch'])->name('admin.application.assign.search')->middleware('permission:stage-change');
Route::post('/admin/application/waiting/search',[TakenOfferController::class,'waitingSearch'])->name('admin.application.waiting.search')->middleware('permission:stage-change');
Route::post('/admin/application/meet/search',[TakenOfferController::class,'meetSearch'])->name('admin.application.meet.search')->middleware('permission:stage-change');
Route::post('/admin/application/trial/search',[TakenOfferController::class,'trialSearch'])->name('admin.application.trial.search')->middleware('permission:stage-change');


Route::post('/admin/job/tutor/match',[AllJobOfferController::class,'matchRate'])->name('admin.job.match.rate');


Route::post('/admin/taken-offer/payment',[TakenOfferController::class,'payment'])->name('admin.taken_offer.payment')->middleware('permission:stage-change');

Route::post('/admin/taken-offer/due/payment',[TakenOfferController::class,'due_payment'])->name('admin.taken_offer.due_payment')->middleware('permission:stage-change');
Route::post('/admin/taken-offer/payment/refund',[TakenOfferController::class,'refundPayment'])->name('admin.taken_offer.refundPayment')->middleware('permission:stage-change');
Route::post('/admin/taken-offer/payment/refund/complete',[TakenOfferController::class,'refundPaymentComplete'])->name('admin.taken_offer.refundPaymentComplete')->middleware('permission:stage-change');



//Sms Balance column Add
Route::get('/admin/sms-balance-add',[BackendTutorController::class,'smsBalanceAdd']);


Route::get('/admin/course-blogs',[CourseBlogPostController::class,'courseBlog'])->name('blog.course')->middleware('permission:category-details');
Route::get('/admin/create-course-blogs',[CourseBlogPostController::class,'createCourseBlog'])->name('blog.course.create')->middleware('permission:category-details-actions');
Route::post('/admin/store-course-blogs',[CourseBlogPostController::class,'storeCourseBlog'])->name('blog.course.store')->middleware('permission:category-details-actions');
Route::any('/admin/edit-course-blogs/{id}',[CourseBlogPostController::class,'editCourseBlog'])->name('blog.course.edit')->middleware('permission:category-details-actions');
Route::post('/admin/update-course-blogs/{id}',[CourseBlogPostController::class,'updateCourseBlog'])->name('blog.course.update')->middleware('permission:category-details-actions');



Route::get('/admin/inactive-tutors',[ InactiveTutorController::class,'index'])->name('admin.inactive.tutor')->middleware('auth');
Route::get('/admin/counting',[ BackendTutorController::class,'counting'])->name('admin.counting')->middleware('auth');



Route::any('/admin/verified',[BackendTutorController::class,'verifiedJobTutor'])->name('admin.verify.tutor.job')->middleware('auth');
Route::any('/admin/premium',[BackendTutorController::class,'premiumJobTutor'])->name('admin.premium.tutor.job')->middleware('auth');
Route::any('/admin/boost',[BackendTutorController::class,'boostJobTutor'])->name('admin.boost.tutor.job')->middleware('auth');

// Transction-history
Route::get('/admin/tutor/transction-history/{id}',[BackendTutorController::class,'trxPayHistory'])->name('admin.tutor.trx.history')->middleware('auth');
Route::get('/admin/tutor/membership-transction-history/{id}',[BackendTutorController::class,'membershiptTrxHistory'])->name('admin.tutor.membership.trx.history')->middleware('auth');
Route::get('/admin/tutor/refund-transction/{id}',[BackendTutorController::class,'refundTrxHistory'])->name('admin.tutor.refund.trx.history')->middleware('auth');
Route::get('/admin/tutor/payment-method/{id}',[BackendTutorController::class,'paymentMethod'])->name('admin.tutor.payment.method')->middleware('auth');
Route::post('/admin/tutor/account-add/{id}',[BackendTutorController::class,'accountAdd'])->name('admin.tutor.account.add')->middleware('auth');
Route::get('/admin/tutor/invoice/{id}',[BackendTutorController::class,'paymentInvoice'])->name('admin.tutor.payment.invoice')->middleware('auth');
Route::get('/admin/tutor/invoice-view/{invoice_no}',[BackendTutorController::class,'invoiceView'])->name('admin.tutor.invoice.view')->middleware('auth');
Route::get('/admin/tutor/refund-invoice/{id}',[BackendTutorController::class,'refundInvoice'])->name('admin.tutor.invoice.refund')->middleware('auth');

//
Route::any('/admin/tutor/reffer-add/{id}',[BackendTutorController::class,'refferAdd'])->name('admin.tutor.reffer.add')->middleware('auth');

Route::get('/export-users', [SettingController::class, 'exportPayment'])->name('export.payment')->middleware('permission:application-payent-data');
Route::get('/export/data', [SettingController::class, 'exportData'])->name('export.data')->middleware('permission:application-payent-data');

Route::get('/export-due', [SettingController::class, 'exportDue'])->name('export.due')->middleware('permission:due-data');
Route::get('/export/date-wise', [SettingController::class, 'exportDateWise'])->name('export.data.date.wise')->middleware('permission:due-data');
Route::get('/export/confirm-job-data', [SettingController::class, 'exportConfirmJob'])->name('export.confirm.job.data')->middleware('permission:confirm-job-data');
Route::get('/export/due-job-data', [SettingController::class, 'exportDueJob'])->name('export.due.job.data')->middleware('permission:due-job-data');


//
// Reviews
Route::get('/admin/tutor-trash-rivews', [ReviewsController::class, 'tutorTrashReviews'])->name('admin.reviews.tutor.trash')->middleware('auth');
Route::get('/admin/tutor-rivews', [ReviewsController::class, 'tutorReviews'])->name('admin.reviews.tutor')->middleware('auth');
Route::any('/admin/tutor-rivew-delete/{id}', [ReviewsController::class, 'tutorReviewDelete'])->name('admin.review.tutor.delete')->middleware('auth');
Route::any('/admin/tutor-rivew-restore/{id}', [ReviewsController::class, 'tutorReviewRestore'])->name('admin.review.tutor.restore')->middleware('auth');
Route::any('/admin/tutor-rivews-search', [ReviewsController::class, 'tutorReviewSearch'])->name('admin.reviews.tutor.search')->middleware('auth');

Route::post('/admin/send-tutor-reviews',[BackendTutorController::class,'sendTutorReviews']);

Route::post('/admin/web-review/status',[ReviewsController::class,'changeStatus'])->name('admin.web_review.status');


// Website Reviews
Route::get('/admin/web-rivews', [ReviewsController::class, 'websiteReviews'])->name('admin.reviews.website')->middleware('auth');
Route::post('/admin/web-rivews-store', [ReviewsController::class, 'websiteReviewsStore'])->name('admin.reviews.website.store')->middleware('auth');
Route::get('/admin/web-reviews/{id}/edit', [ReviewsController::class, 'websiteReviewsedit'])->middleware('auth');
Route::post('/admin/web-reviews/update', [ReviewsController::class, 'websiteReviewsupdate'])->middleware('auth');


Route::middleware(['auth'])->group(function () {
    // Web leads
    Route::get('/admin/web-leads', [WebleadController::class, 'webLead'])->name('admin.web.lead')->middleware('permission:web-lead');
    Route::any('/admin/web-leads/search', [WebleadController::class, 'webLeadSearch'])->name('admin.web.lead.search')->middleware('permission:web-lead');
    Route::any('/admin/web/leads/reject/job/{lead_id}',[ WebleadController::class,'webLeadJobReject'])->name('admin.wev.lead.job.rejected')->middleware('permission:web-lead-action');
    Route::any('/admin/web/leads/approve/job/{lead_id}',[ WebleadController::class,'webLeadJobApprove'])->name('admin.wev.lead.job.approve')->middleware('permission:web-lead-action');
    Route::get('/admin/tutor-request', [CategoryTutorRequestController::class, 'tutorRequest'])->name('admin.request.tutor')->middleware('permission:tutor-request');
    Route::any('/admin/tutor-request-filter', [CategoryTutorRequestController::class, 'tutorRequestFilter'])->name('admin.tutor.request.filter')->middleware('permission:tutor-request');
    Route::any('/admin/tutor-request-search', [CategoryTutorRequestController::class, 'tutorRequestSearch'])->name('admin.tutor.request.search')->middleware('permission:tutor-request');


    // Category Request
    Route::get('/admin/tutor-category-request', [CategoryTutorRequestController::class, 'index'])->name('admin.cat.request')->middleware('permission:category-request');
    Route::any('/admin/tutor-category-request/reject/{id}', [CategoryTutorRequestController::class, 'catRequestReject'])->name('admin.cat.request.reject')->middleware('permission:category-request-action');
    Route::any('/admin/tutor-category-request/note-add/{id}', [CategoryTutorRequestController::class, 'catRequestNoteAdd'])->name('admin.cat.request.note.add')->middleware('permission:category-request-action');
    Route::any('/admin/tutor-category-request/note-add-admin/{id}', [CategoryTutorRequestController::class, 'catRequestNoteAddAdmin'])->name('admin.cat.request.note.add.admin')->middleware('permission:category-request-action');
    Route::any('/admin/cat-request-filter', [CategoryTutorRequestController::class, 'catRequestFilter'])->name('admin.cat.request.filter')->middleware('permission:category-request');
    Route::any('/admin/cat-request-search', [CategoryTutorRequestController::class, 'catRequestSearch'])->name('admin.cat.request.search')->middleware('permission:category-request');

    // Verify Request
    Route::any('/admin/verify-request',[ VerificationRequestController::class,'index'])->name('admin.verify.request')->middleware('permission:verify-request');
    Route::any('/admin/verify-request-search',[VerificationRequestController::class,'verifyRequestSearch'])->name('admin.verify.request.search')->middleware('permission:verify-request-action');
    Route::post('/admin/grant-verify-application',[VerificationRequestController::class,'grantApplication'])->name('admin.grant.verification.request')->middleware('permission:verify-request-action');
    Route::post('/admin/decline-verify-application',[VerificationRequestController::class,'declineApplication'])->name('admin.decline.verify.application')->middleware('permission:verify-request-action');
    Route::any('/admin/verify-filter',[VerificationRequestController::class,'filterVerifyApplication'])->name('admin.filter.verify.application')->middleware('permission:verify-request-action');
    Route::any('/admin/verify-request-add',[VerificationRequestController::class,'verifyRequestAdd'])->name('admin.add.verify.application')->middleware('permission:verify-request-action');
    Route::post('/admin/verify-waiting',[VerificationRequestController::class,'waitingVerifyApplication'])->name('admin.waiting.verify.application')->middleware('permission:verify-request-action');
    Route::any('/admin/verify-request-note',[VerificationRequestController::class,'verifyRequestNote'])->name('admin.verify.request.note')->middleware('permission:verify-request-action');


    // PremiumMembership
    Route::any('/admin/premium-membership-request-search',[BackendTutorController::class,'premiumMembershipSearch'])->name('admin.premium.member.search')->middleware('permission:premium-request');
    Route::get('/admin/premium-membership-request',[BackendTutorController::class,'premiumMembership'])->name('admin.premium.membership')->middleware('permission:premium-request-action');
    Route::any('/admin/premium-membership-request-note',[BackendTutorController::class,'premiumMembershipNote'])->name('admin.premium.membership.note')->middleware('permission:premium-request-action');
    Route::post('/admin/grant-membership-application',[BackendTutorController::class,'grantApplication'])->name('admin.grant.membership.application')->middleware('permission:premium-request-action');
    Route::post('/admin/decline-membership-application',[BackendTutorController::class,'declineApplication'])->name('admin.decline.membership.application')->middleware('permission:premium-request-action');
    Route::any('/admin/premium-membership-filter',[BackendTutorController::class,'filterMemberApplication'])->name('admin.filter.membership.application')->middleware('permission:premium-request-action');
    Route::any('/admin/premium-membership-add',[BackendTutorController::class,'premiumMemberAdd'])->name('admin.add.membership.application')->middleware('permission:premium-request-action');
    Route::post('/admin/premium-membership-waiting',[BackendTutorController::class,'waitingMemberApplication'])->name('admin.waiting.membership.application')->middleware('permission:premium-request-action');


    // Parent lead
    Route::get('/admin/parent/leads',[ BackendParentJobController::class,'parentLead'])->name('admin.parent.leads')->middleware('permission:parent-lead');
    Route::post('/admin/parent/leads/note/{lead_id}',[ BackendParentJobController::class,'parentLeadNote'])->name('admin.parent.lead.note.add')->middleware('permission:parent-lead-action');
    Route::get('/admin/parent/lead/view/{id}',[ BackendParentJobController::class,'parentLeadView'])->name('admin.parent.lead.view')->middleware('permission:parent-lead-action');
    Route::any('/admin/parent/leads/search',[ BackendParentJobController::class,'parentLeadSearch'])->name('admin.parent.leads.search')->middleware('permission:parent-lead-action');
    Route::any('/admin/parent/leads/post/job/{lead_id}',[ BackendParentJobController::class,'parentLeadJobPost'])->name('admin.parent.lead.job.post')->middleware('permission:parent-lead-action');
    Route::any('/admin/parent/leads/reject/job/{lead_id}',[ BackendParentJobController::class,'parentLeadJobReject'])->name('admin.parent.lead.job.rejected')->middleware('permission:parent-lead-action');

    // Parent Fnf Lead
    Route::get('/admin/parent-fnf/leads',[ BackendParentJobController::class,'parentFnfLead'])->name('admin.parent.fnf.leads')->middleware('permission:parent-fnf-lead');
    Route::any('/admin/parent/fnf-leads/post/job/{lead_id}',[ BackendParentJobController::class,'parentFnfLeadJobPost'])->name('admin.parent.fnf.lead.job.post')->middleware('permission:parent-fnf-lead-action');
    Route::any('/admin/parent/fnf-leads/reject/job/{lead_id}',[ BackendParentJobController::class,'parentFnfLeadJobReject'])->name('admin.parent.fnf.lead.job.reject')->middleware('permission:parent-fnf-lead-action');
    Route::any('/admin/parent/fnf-leads/admin/note/{lead_id}',[ BackendParentJobController::class,'parentFnfLeadAdminNote'])->name('admin.parent.fnf.lead.admin.note')->middleware('permission:parent-fnf-lead-action');

    // All Notice



});
});

Route::post('/session/keep-alive', function (Request $request) {
    if (Auth::check()) {
        Session::put('last_activity', now());
        return response()->json(['status' => 'updated']);
    }
    return response()->json(['status' => 'not_logged_in'], 401);
})->name('session.keep-alive');

include("payment.php");
// include("notice.php");
include("parentaction.php");
include("parent.php");
include("setting.php");
include("takenoffer.php");

require __DIR__.'/notice.php';