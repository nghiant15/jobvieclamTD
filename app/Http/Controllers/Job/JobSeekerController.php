<?php

namespace App\Http\Controllers\Job;

use Auth;
use DB;
use Input;
use Redirect;
use Carbon\Carbon;
use App\User;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Traits\FetchJobSeekers;
use App\JobApply;
use App\CareerLevel;

class JobSeekerController extends Controller
{

    //use Skills;
    use FetchJobSeekers;

    private $functionalAreas = '';
    private $countries = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $this->countries = DataArrayHelper::langCountriesArray();
    }

    public function jobSeekersBySearch(Request $request)
    {   
      
        $timeUpdate = $request->query('thoi-gian-cap-nhat', '');
    
        $wayWork = $request->query('hinh-thuc-lam-viec', '');
        $location = $request->query('dia-diem', '');
        $tinhthanh = $request->query('tinh-thanh', '');
        $linhvuc = $request->query('linh-vuc', '');
        $search = $request->query('tu-khoa', '');

        
      
        $functional_area_ids = $request->query('functional_area_id', array());
        $country_ids = $request->query('country_id', array());
        $state_ids = $request->query('state_id', array());
        $city_ids = $request->query('city_id', array());
        $career_level_ids = $request->query('career_level_id', array());
        $gender_ids = $request->query('gender_id', array());
        $industry_ids = $request->query('industry_ids', array());
        $job_experience_ids = $request->query('job_experience_id', array());
        $current_salary = $request->query('current_salary', '');
        $expected_salary = $request->query('expected_salary', '');
        $salary_currency = $request->query('salary_currency', '');
        $order_by = $request->query('order_by', 'id');
        $limit = 10;
        $jobSeekers = User::where("is_active",1);
        $jobSeekers =$jobSeekers->paginate(10);
        $jobAply =  JobApply::paginate(10);
         /*         * ************************************************** */

        $jobSeekerIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.id');

        /*         * ************************************************** */

        $skillIdsArray = $this->fetchSkillIdsArray($jobSeekerIdsArray);

        /*         * ************************************************** */

        $countryIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.country_id');

        /*         * ************************************************** */

        $stateIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.state_id');

        /*         * ************************************************** */

        $cityIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.city_id');

        /*         * ************************************************** */

        $industryIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.industry_id');

        /*         * ************************************************** */


        /*         * ************************************************** */

        $functionalAreaIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.functional_area_id');

        /*         * ************************************************** */

        $careerLevelIdsArray =  CareerLevel::where("lang","vi")->get();
    
    
        /*         * ************************************************** */

        $genderIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.gender_id');

        /*         * ************************************************** */

        $jobExperienceIdsArray = $this->fetchIdsArray($search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency, 'users.job_experience_id');

        /*         * ************************************************** */

        $seoArray = $this->getSEO($functional_area_ids, $country_ids,
         $state_ids, $city_ids, $career_level_ids,
          $gender_ids, $job_experience_ids);

        /*         * ************************************************** */

        $currencies = DataArrayHelper::currenciesArray();

        /*         * ************************************************** */


        $cities  = \App\City::where('lang', \App::getLocale())->active()->get();
      
        $industryIds  = \App\Industry::where('lang', \App::getLocale())->active()->get();
    
        $seo = (object) array(
                    'seo_title' => $seoArray['description'],
                    'seo_description' => $seoArray['description'],
                    'seo_keywords' => $seoArray['keywords'],

                    'seo_other' => ''
        );
        return view(config('app.THEME_PATH').'.user.list')
                        ->with('functionalAreas', $this->functionalAreas)
                        ->with('countries', $this->countries)
                        ->with('currencies', array_unique($currencies))
                        ->with('jobSeekers', $jobSeekers)
                        ->with('skillIdsArray', $skillIdsArray)
                        ->with('countryIdsArray', $countryIdsArray)
                        ->with('stateIdsArray', $stateIdsArray)
                        ->with('cityIdsArray', $cityIdsArray)
                        ->with('industryIdsArray', $industryIdsArray)
                        ->with('functionalAreaIdsArray', $functionalAreaIdsArray)
                        ->with('careerLevelIdsArray', $careerLevelIdsArray)
                        ->with('genderIdsArray', $genderIdsArray)
                        ->with('jobExperienceIdsArray', $jobExperienceIdsArray)
                        ->with('cities', $cities)
                        ->with('jobAply', $jobAply)
                        ->with('requestParam',$request)
                        ->with('industryIds', $industryIds)
                        ->with('seo', $seo);
    }

}
