<?php

namespace App\Http\Controllers;

use App\Http\Resources\AwardResource;
use App\Http\Resources\LeaveResource;
use App\Http\Resources\PayrollResource;
use App\Mail\NewEmployeeRegister;
use App\Models\Address;
use App\Models\AdminLog;
use App\Models\Attendance;
use App\Models\Award;
use App\Models\BusinessType;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientCorporateUser;
use App\Models\ClientEmployeeUser;
use App\Models\Company;
use App\Models\Country;
use App\Models\Department;
use App\Models\Industry;
use App\Models\Leave;
use App\Models\NoticeBoard;
use App\Models\Payroll;
use App\Models\Permission;
use App\Models\Person;
use App\Models\PersonPersonalInformation;
use App\Models\Portfolio;
use App\Models\Religion;
use App\Models\State;
use App\Models\VisitingCard;
use App\Services\ActivityLogService;
use App\User;
use Carbon\Carbon;
use EchoLabs\Prism\Prism;
use Exception;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
    }

    /**
     * Add Religions data
     */
    public function addReligion()
    {
        $arr = [
            'African Traditional & Diasporic',
            'Agnostic',
            'Atheist',
            'Baha\'i',
            'Buddhism',
            'Cao Dai',
            'Chinese traditional religion',
            'Christianity',
            'Hinduism',
            'Islam',
            'Jainism',
            'Juche',
            'Judaism',
            'Neo Paganism',
            'Nonreligious',
            'Rastafarianism',
            'Secular',
            'Shinto',
            'Sikhism',
            'Spiritism',
            'Tenrikyo',
            'Unitarian Universalism',
            'Zoroastrianism',
            'Primal Indigenous',
            'Other'
        ];

        foreach ($arr as $ar) {
            $reg = new Religion();
            $reg->name = $ar;
            $reg->save();
        }
    }

    /**
     *
     */
    public function updateContinent()
    {
        $getCountries = Country::select('id', 'continent_id')->get();

        foreach ($getCountries as $country) {
            State::where('country_id', $country->id)->update(['continent_id' => $country->continent_id]);
            City::where('country_id', $country->id)->update(['continent_id' => $country->continent_id]);
        }

        echo "Success";
    }

    /**
     *
     */
    public function updateCountry()
    {
        $getCountries = Country::select('id', 'name', 'slug')->get();

        foreach ($getCountries as $country) {
            $country->slug = convertStringToSlug($country->name);
            $country->save();
        }

        echo "Success";
    }

    /**
     *
     */
    public function updateState()
    {
        $getState = State::select('id', 'name', 'slug')->get();

        foreach ($getState as $state) {
            $state->slug = convertStringToSlug($state->name);
            $state->save();
        }

        echo "Success";
    }

    /**
     *
     */
    public function updateCity()
    {
        $getCity = City::select('id', 'name', 'slug')->take(20000)->skip(160000)->get();

        foreach ($getCity as $city) {
            $city->slug = convertStringToSlug($city->name);
            $city->save();
        }

        echo "Success";
    }

    /**
     *
     */
    public function updateBusinessType()
    {
        $getBusinessType = BusinessType::select('id', 'name', 'slug', 'status')->get();

        foreach ($getBusinessType as $business) {
            $business->slug = convertStringToSlug($business->name);
            $business->status = 1;
            $business->save();
        }

        echo "Success";
    }

    /**
     *
     */
    public function getContinent()
    {
        return getContinents();
    }

    /**
     *
     */
    public function getCountryByContinentID($continent_id = null)
    {
        return getCountryByContinentID($continent_id);
    }

    /**
     *
     */
    public function getStateByCountryID($country_id = null)
    {
        return getStateByCountryID($country_id);
    }

    /**
     *
     */
    public function getCityByStateByID($state_id = null)
    {
        return getCityByStateByID($state_id);
    }

    /**
     *
     */
    public function getSocialMediaPlatform()
    {
        return getSocialMediaPlatform();
    }

    /**
     *
     */
    public function updateIndustryHexCode()
    {
        $dataObj = Industry::all();

        foreach ($dataObj as $data) {
            $hexCode = generateRandomHexColor();
            $rgbCode = hexToRgb($hexCode);

            $data->hax_code = $hexCode;
            $data->rgb_code = $rgbCode;
            $data->save();
        }
    }

    /**
     *
     */
    public function updateCompany()
    {
        $getCompanies = Company::select('id', 'hax_code', 'rgb_code')->get();

        foreach ($getCompanies as $company) {
            $hax_code = generateRandomHexColor();
            $company->hax_code = $hax_code;
            $company->rgb_code = hexToRgb($hax_code);
            $company->save();
        }

        echo "Success";
    }

    /**
     *
     */
    public function updateDepartment()
    {

        Storage::makeDirectory('/app/public/1/personalDetails');

        // $getDept = Department::select( 'id', 'hax_code', 'rgb_code' )->get();

        // foreach( $getDept as $dept ){
        //     $hax_code = generateRandomHexColor();
        //     $dept->hax_code = $hax_code;
        //     $dept->rgb_code = hexToRgb( $hax_code );
        //     $dept->save();
        // }

        echo "Success";
    }

    /**
     * Temp Client data store
     */
    public function storeClientRandomData()
    {
        $admin_id = $user_id = 1;
        for ($i = 0; $i < 50; $i++) {

            $continentArr = getRandomContinent();
            $continent_id = $continentArr['continent_id'];
            $country_id = $continentArr['country_id'];
            $state_id = $continentArr['state_id'];
            $city_id = $continentArr['city_id'];

            str()->random();

            //generate random gender number
            $numbers = [1, 2, 3];

            //generate random mobile number
            $faker = Factory::create();

            //random generate join date
            $timestamp = rand(strtotime('-180 days'), time());

            $clientDataObj = new Client();
            $clientDataObj->admin_id = $admin_id;
            $clientDataObj->user_id = $user_id;
            $clientDataObj->unique_id = date('my') . appendClientUniqueId();

            $firstName = str()->random();
            $lastName = str()->random();

            $industryArr = [4, 40, 41, 71, 87, 94];

            //get random industry detail
            $industry_id = $industryArr[array_rand($industryArr)]; //Industry::select('id', 'name')->where( ['status' => 1, 'type' => 1 ])->orderBy('sort_order', 'ASC')->orderBy('name', 'ASC')->inRandomOrder()->limit(1)->get();
            $clientDataObj->industry_id = $industry_id;

            //get random industry base company detail
            $company = Company::select('id', 'name')->where(['status' => 1, 'industry_id' => $industry_id])->orderBy('name', 'ASC')->inRandomOrder()->first()->toArray();
            // dd( $company, $industry_id );
            $clientDataObj->company_id = $company['id'];

            //get random industry & company base department detail
            $department = Department::select('id', 'name')->where(['industry_id' => $industry_id, 'company_id' => $company['id'], 'sort_order' => 1])->first();
            $clientDataObj->department_id = $department->id;
            $clientDataObj->first_name = $firstName;
            $clientDataObj->middle_name = str()->random();
            $clientDataObj->last_name = $lastName;
            $clientDataObj->email_id = str()->random() . "@mailinator.com";
            $clientDataObj->gender = $numbers[array_rand($numbers)];
            $clientDataObj->mobile_number = $faker->phoneNumber;

            //get random religion detail
            $religion = Religion::select('id')->where('status', 1)->inRandomOrder()->limit(1)->get();
            $clientDataObj->religion_id = $religion[0]->id;
            $clientDataObj->joining_date = date('Y-m-d', $timestamp);
            $clientDataObj->social_medias = null;
            $clientDataObj->isSendRegisterMail = 0;
            $clientDataObj->other_info = str()->random();
            $clientDataObj->save();

            $clientId = $clientDataObj->id;

            //save client admin activity log
            $tblDetails['item_name'] = "Client";
            $tblDetails['group_name'] = "client";
            $tblDetails['table_name'] = 'clients';
            $tblDetails['table_field'] = 'All';
            $tblDetails['primaryId'] = $clientId;
            $tblDetails['parent_table_pk_id'] = $clientId;
            $tblDetails['description'] = "Generate new Client (" . $firstName . " " . $lastName . ") data records.";
            ActivityLogService::log($admin_id, $user_id, 'A', $tblDetails);


            //save client addresses
            $clientAddressObj = new Address();
            $clientAddressObj->admin_id = $admin_id;
            $clientAddressObj->client_id = $clientId;
            $clientAddressObj->unique_id = date('my') . appendClientAddressUniqueId($clientId);
            $clientAddressObj->name = $firstName . " " . str()->random() . " " . $lastName;
            $clientAddressObj->email_id = str()->random() . "@mailinator.com";
            $clientAddressObj->address = str()->random();
            $clientAddressObj->contact_number = $faker->phoneNumber;
            $clientAddressObj->continent_id = $continent_id;
            $clientAddressObj->country_id = $country_id;
            $clientAddressObj->state_id = $state_id;
            $clientAddressObj->city_id = $city_id;
            $clientAddressObj->zipcode = Str::random(6);
            $clientAddressObj->type = 1; // 1: Permanent, 2: Temporary
            $clientAddressObj->person_type = 3; //1: Employee, 2: Customer, 3: Client
            $clientAddressObj->description = null;
            $clientAddressObj->save();

            $addressType = "";
            //set client permanent address
            if ($clientAddressObj->type == 1) {
                $clientDataObj->continent_id = $continent_id;
                $clientDataObj->country_id = $country_id;
                $clientDataObj->state_id = $state_id;
                $clientDataObj->city_id = $city_id;
                $clientDataObj->save();

                $addressType = "primary ";
            }

            //save client admin activity log
            $tblDetails['table_name'] = 'addresses';
            $tblDetails['table_field'] = 'All';
            $tblDetails['primaryId'] = $clientAddressObj->id;
            $tblDetails['parent_table_pk_id'] = $clientId;
            $tblDetails['description'] = "Generate client " . $addressType . "address (" . $clientAddressObj->unique_id . ") data records.";
            ActivityLogService::log($admin_id, $user_id, 'A', $tblDetails);

            //check client type corporate employee user
            if ($i % 2 == 0) {
                $corporateName = str()->random();
                $clientCorporateUser = new ClientCorporateUser();
                $clientCorporateUser->admin_id = $admin_id;
                $clientCorporateUser->user_id = $user_id;
                $clientCorporateUser->client_id = $clientId;
                $clientCorporateUser->name = $corporateName;
                $clientCorporateUser->email_id = str()->random() . "@mailinator.com";
                $clientCorporateUser->website = str()->random() . ".com";
                $clientCorporateUser->mobile_number = $faker->phoneNumber;
                $clientCorporateUser->description = str()->random();
                $clientCorporateUser->industry_id = $industry_id;
                $clientCorporateUser->address = str()->random();
                $clientCorporateUser->continent_id = $continent_id;
                $clientCorporateUser->country_id = $country_id;
                $clientCorporateUser->state_id = $state_id;
                $clientCorporateUser->city_id = $city_id;
                $clientCorporateUser->zipcode = Str::random(6);
                $clientCorporateUser->save();

                //save client admin activity log
                $tblDetails['table_name'] = 'client_corporarte_users';
                $tblDetails['table_field'] = 'All';
                $tblDetails['primaryId'] = $clientCorporateUser->id;
                $tblDetails['parent_table_pk_id'] = $clientId;
                $tblDetails['description'] = "Generate corporate user(" . $corporateName . ") data records.";
                ActivityLogService::log($admin_id, $user_id, 'A', $tblDetails);
            } else {
                $jobTitle = str()->random();
                $clientEmployeeUser = new ClientEmployeeUser();
                $clientEmployeeUser->admin_id = $admin_id;
                $clientEmployeeUser->user_id = $user_id;
                $clientEmployeeUser->client_id = $clientId;
                $clientEmployeeUser->job_title = $jobTitle;
                $clientEmployeeUser->job_experience = rand();
                $clientEmployeeUser->company_name = str()->random();
                $clientEmployeeUser->company_website = str()->random() . ".com";
                $clientEmployeeUser->company_email = str()->random() . "@mailinator.com";
                $clientEmployeeUser->company_mobile = $faker->phoneNumber;;
                $clientEmployeeUser->company_landline = "";
                $clientEmployeeUser->job_description = str()->random();
                $clientEmployeeUser->company_address = str()->random();
                $clientEmployeeUser->continent_id = $continent_id;
                $clientEmployeeUser->country_id = $country_id;
                $clientEmployeeUser->state_id = $state_id;
                $clientEmployeeUser->city_id = $city_id;
                $clientEmployeeUser->zipcode = Str::random(5);
                $clientEmployeeUser->company_facebook_url = str()->random() . ".com";
                $clientEmployeeUser->company_twitter_url = str()->random() . ".com";
                $clientEmployeeUser->company_linked_in_url = str()->random() . ".com";
                $clientEmployeeUser->save();

                //save client admin activity log
                $tblDetails['table_name'] = 'client_employee_users';
                $tblDetails['table_field'] = 'All';
                $tblDetails['primaryId'] = $clientEmployeeUser->id;
                $tblDetails['parent_table_pk_id'] = $clientId;
                $tblDetails['description'] = "Generate employee user(" . $jobTitle . ") data records.";
                ActivityLogService::log($admin_id, $user_id, 'A', $tblDetails);
            }
        }
    }

    /**
     *
     */
    public function getAdminMenu()
    {
        return getMultiLevelAdminMenuDropdown();
    }

    /**
     *
     */
    public function getIndustries()
    {
        return getIndustries();
    }

    /**
     *
     */
    public function getCompaniesByIndustryID($industry_id)
    {

        if (is_numeric($industry_id)) {
            return getCompanyByIndustryID($industry_id);
        } else {
            try {
                $industry_id = _de($industry_id);

                $companyData = Company::where(['industry_id' => $industry_id, 'status' => 1])->orderBy('name', 'ASC')->get();
                $responseArr = [];
                foreach ($companyData as $k => $data) {
                    $responseArr[$k]['id'] = _en($data->id);
                    $responseArr[$k]['name'] = $data->name;
                }

                $response = [
                    'success' => true,
                    'data'    => $responseArr,
                    'message' => "Retrive data successfully",
                ];

                return response()->json($response, 200);
            } catch (Exception $e) {
                $response = [
                    'success' => false,
                    'data'    => [],
                    'message' => "Sorry !! You are Unauthorized to Access this company data!",
                ];
                return response()->json($response, 403);
            }
        }
    }

    /**
     *
     */
    public function getDepartmentByCompanyID($company_id)
    {
        if (is_numeric($company_id)) {
            return getDepartmentByCompanyID($company_id);
        } else {
            try {
                $company_id = _de($company_id);

                $companyData = Department::where(['company_id' => $company_id, 'status' => 1])->orderBy('name', 'ASC')->get();
                $responseArr = [];
                foreach ($companyData as $k => $data) {
                    $responseArr[$k]['id'] = _en($data->id);
                    $responseArr[$k]['name'] = $data->name;
                }

                $response = [
                    'success' => true,
                    'data'    => $responseArr,
                    'message' => "Retrive data successfully",
                ];

                return response()->json($response, 200);
            } catch (Exception $e) {
                $response = [
                    'success' => false,
                    'data'    => [],
                    'message' => "Sorry !! You are Unauthorized to Access this company data!",
                ];
                return response()->json($response, 403);
            }
        }
    }

    /**
     *
     */
    public function getChildPositionList($parent_id)
    {
        return getChildPositionList($parent_id);
    }

    /**
     *
     */
    public function getPositionDetails($id)
    {
        return getPositionDetails($id);
    }

    /**
     *
     */
    public function getParentIllnessList()
    {
        return getParentIllnessList();
    }

    /**
     *
     */
    public function getIllnessList($parent_id)
    {
        return getIllnessList($parent_id);
    }

    /**
     *
     */
    public function getMaritalStatus()
    {
        return getMaritalStatus();
    }

    /**
     *
     */
    public function getAllPositionList()
    {
        return getAllPositionList();
    }

    /**
     *
     */
    public function getParentPositionList()
    {
        return getParentPositionList();
    }

    /**
     *
     */
    public function getSkillList($parent_id = 0)
    {
        return getSkillList($parent_id);
    }

    /**
     *
     */
    public function getEmployeeTypeList()
    {
        return getEmployeeTypeList();
    }

    /**
     *
     */
    public function getEmployeeList()
    {
        $response = [
            'success' => true,
            'data'    => Person::select('id', 'first_name', 'last_name', 'middle_name')->where(['type' => 1])->orderBy('first_name', 'ASC')->get()->toArray(),
            'message' => "Retrive Employees Successfully",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeeListByCompanyBase( $company_id = 0)
    {
        $response = [
            'success' => true,
            'data'    => Person::where(['company_id' => $company_id, 'type' => 1, 'status' => 1])->orderBy('first_name', 'ASC')->get()->toArray(),
            'message' => "Retrive Employee List Successfully",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeeDetails( $id = 0)
    {
        $response = [
            'success' => true,
            'data'    => Person::where(['id' => $id])->first()->toArray(),
            'message' => "Retrive Employee Details Successfully",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeePersonalInformation( $employeeId = null )
    {
        $response = [
            'success' => true,
            'data'    => PersonPersonalInformation::where(['person_id' => $employeeId])->first()->toArray(),
            'message' => "Retrive Employee Benefit Informations",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeeNoticeHistory( $employeeId = null )
    {
        $response = [
            'success' => true,
            'data'    => NoticeBoard::where(['employee_id' => $employeeId])->get()->toArray(),
            'message' => "Retrive Employee Notice History",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeeAttandanceHistory( $employeeId = null )
    {
        $response = [
            'success' => true,
            'data'    => Attendance::where(['person_id' => $employeeId])->get()->toArray(),
            'message' => "Retrive Employee Attandance History",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeeLeaveHistory( $employeeId = null )
    {
        $dataObj = Leave::where(['person_id' => $employeeId])->get();

        $response = [
            'success' => true,
            'data'    => LeaveResource::collection( $dataObj ),
            'message' => "Retrive Employee Leave History",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeePayrollHistory( $employeeId = null )
    {
        $dataObj = Payroll::where(['person_id' => $employeeId])->get();

        $response = [
            'success' => true,
            'data'    => PayrollResource::collection( $dataObj ),
            'message' => "Retrive Employee Payroll History",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getEmployeeAwardHistory( $employeeId = null )
    {
        $dataObj = Award::where(['person_id' => $employeeId])->get();

        $response = [
            'success' => true,
            'data'    => AwardResource::collection( $dataObj ),
            'message' => "Retrive Employee Award History",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function getPaymentFrequency()
    {
        return getPaymentFrequency();
    }

    /**
     *
     */
    public function clonePermission()
    {

        $userRole = Role::where(['name' => 'user', 'guard_name' => 'web'])->first();
        $permission = Permission::where('guard_name', 'user')->get();

        foreach ($permission as $ar) {
            $userRole->givePermissionTo($ar);
        }

        // Assign role to user (web guard)
        $user = User::find(1); // Example user
        $user->assignRole('user');

        echo "Success";
    }

    /**
     *
     */
    public function cloneRolePermission()
    {

        for ($i = 147; $i <= 272; $i++) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $i,
                'role_id' => 2,
            ]);
        }

        echo "Success";
    }

    /**
     *
     */
    public function getReligions()
    {
        return getReligions();
    }

    /**
     *
     */
    public function getShiftList()
    {
        return getShiftList();
    }

    /**
     *
     */
    public function getShiftDetailList($id)
    {
        return getShiftDetailList($id);
    }

    /**
     *
     */
    public function getHolidayList()
    {
        return getHolidayList();
    }

    /**
     * update client Email id
     */
    public function updateClientEmail()
    {
        $clientObjs = Person::where('type', 3)->select('id', 'unique_id', 'email_id')->get();

        foreach ($clientObjs as $cr) {
            $cr->email_id = $cr->unique_id . "@mailinator.com";
            $cr->save();
        }
    }

    /**
     * send temp mail
     */
    public function sendTempMail()
    {
        $data = [
            'name' => "Gautam Kakadiya",
            'company_name' => 'Devotion Business',
            'register_link' => url('complete-register/' . _en(1)),
        ];

        Mail::to('gk@mailinator.com')->send(new NewEmployeeRegister($data));
    }

    /**
     *
     */
    public function prismAI()
    {
        $prism = Prism::text()
            ->using('openai', 'gpt-4o')
            ->withSystemPrompt(view('prompts.ai'))
            ->withPrompt('Explain quantum computing to a 5-year-old.');

        $response = $prism();

        echo $response->text;
    }

    /**
     *
     */
    public function clearEmployeeDatabaseHistory()
    {
        //get Employee history
        $empObjs = Person::where('type', 1)->get()->pluck('id');
        if ($empObjs) {
            foreach ($empObjs as $id) {
                removeEmployeeHistoryData($id);
            }
        }

        echo "Remove all " . COUNT($empObjs) . " employee datas";
    }

    /**
     *
     */
    public function clearClientDatabaseHistory()
    {
        //get Client history
        $clientObjs = Client::all()->pluck('id');
        if ($clientObjs) {
            foreach ($clientObjs as $id) {
                removeClientHistoryData($id);
            }
        }

        echo "Remove all " . COUNT($clientObjs) . " client datas";
    }

    /**
     *
     */
    public function getLogos()
    {
        return getLogos();
    }

    /**
     *
     */
    public function getQualifications($parent_id = 0)
    {
        return getQualifications($parent_id);
    }

    /**
     *
     */
    public function getCommunicationType()
    {
        return getCommunicationType('API');
    }

    /**
     * get all activity logs
     */
    public function getActivityLogs($parent_table_pk_id = null)
    {

        $where = [];
        if ($parent_table_pk_id) {
            $where['parent_table_pk_id'] = $parent_table_pk_id;
        }

        $logHistory = [];
        $logHistoryObj = AdminLog::where($where)->get();

        $actionArr = [
            'A' => "Add",
            'E' => "Edit",
            'D' => "Delete",
            'CU' => "Create or Update"
        ];
        if (count($logHistoryObj) > 0) {
            foreach ($logHistoryObj as $k => $data) {
                $logHistory[$k]['user'] =  ucfirst( $data->admin->username );
                $logHistory[$k]['table'] = $data->table_name;
                $logHistory[$k]['field'] = $data->table_field;
                $logHistory[$k]['action'] = $actionArr[$data->action];
                $logHistory[$k]['ip_address'] = $data->log_ip;
                $logHistory[$k]['description'] = $data->description;
                $logHistory[$k]['created_at'] =  formatDate("Y-m-d H:i", $data->created_at);
            }
        }
        $response = [
            'success' => true,
            'data'    => $logHistory,
            'message' => "Retrive log history data successfully",
        ];

        return response()->json($response, 200);
    }

    /**
     * Recursively deletes empty folders in the given directory.
     *
     * @param string $directory The directory to check for empty folders.
     */
    function deleteEmptyFolders( $directory = '' )
    {
        // Get all directories within the specified directory
        $directories = Storage::directories($directory);

        // Recursively check and delete empty child folders
        foreach ($directories as $dir) {
            $this->deleteEmptyFolders($dir); // Recursive call for subdirectories
        }

        // After processing subdirectories, check if the current directory is empty
        if ( empty( Storage::files( $directory ) ) && empty( Storage::directories( $directory ) ) ) {
            Storage::deleteDirectory($directory);
            echo "Deleted empty folder: {$directory}\r\n";
        }
    }

    /**
     * Manually Removing One-Day-Old Sessions
     */
    public function removeOldFrameworkSessionFiles()
    {
        $sessionPath = storage_path('framework/sessions');
        $files = File::files($sessionPath);

        $count = 0;
        foreach ($files as $file) {
            $lastModified = Carbon::createFromTimestamp($file->getMTime());
            if (now()->diffInDays($lastModified) > 1) {
                File::delete($file);

                $count++;
            }
        }

        echo "Remove total session files in framework folder is: " . $count;

        $viewPath = storage_path('framework/views');
        $files = File::files($viewPath);

        $count = 0;
        foreach ($files as $file) {
            $lastModified = Carbon::createFromTimestamp($file->getMTime());
            if (now()->diffInDays($lastModified) > 5) {
                File::delete($file);

                $count++;
            }
        }

        echo "<br>Remove total vies files in framework folder is: " . $count;
    }

    /**
     *
     */
    public function getVisitingCardDetails( $companySlug, $emailSlug ){

        //get Company Details
        $companyObj = Company::where( 'slug', $companySlug )->first();

        //get Employee Details
        $details = VisitingCard::where( 'slug', $emailSlug )->first();
        // $details->view += 1;
        // $details->save();

        $canonical = request()->url();
        return view( 'visiting-card/'.$companySlug, compact( 'companyObj', 'details', 'canonical' ) );
    }

    /**
     *
     */
    public function downloadContact( $id ){
        $details = VisitingCard::find( $id );

        header('Content-Type: text/vcard');
        header('Content-Disposition: attachment; filename="'.convertStringToSlug( $details->name ).'.vcf"');

        echo "BEGIN:VCARD\r\n";
        echo "VERSION:3.0\r\n";
        echo "FN:$details->name\r\n";
        echo "TEL:$details->mobile_number\r\n";
        echo "ORG:$details->company->name\r\n";
        echo "TITLE:$details->position\r\n";
        echo "EMAIL:$details->email\r\n";
        echo "END:VCARD\r\n";
        exit;
    }
}
