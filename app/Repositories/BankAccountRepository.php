<?php


namespace App\Repositories;

use App\BankAccount;
use App\FinancialOrganization;
use App\AccountType;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

//use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use PDF;

class BankAccountRepository
{


    /**
     * User constructor.
     */
    public function __construct(BankAccount $bankAccount)

    {

    }

    public function index()
    {
        $financial_organizations = FinancialOrganization::all();
        $account_types = AccountType::all();
//        dd($financial_organizations);
        $bank_accounts = BankAccount::paginate(10);
        return view('bank_accounts.index', compact('financial_organizations', 'bank_accounts','account_types'));
    }


    public function storeUsers(Request $request)
    {

        $account_name = $request->account_name;
        $bank = $request->bank;
        $account_no = $request->account_no;
        $branch = $request->branch;
        $account_type = $request->account_type;
        $swift_code = $request->swift_code;
        $route_no = $request->route_no;

        $err = "";


        $error = "<ul>";

        if (!$account_name) {
            $err = 1;
            $error .= "<li><b>Please key in Account Name</b></li>";
        }
        if (!$bank) {
            $err = 1;
            $error .= "<li><b>Please key in Bank</b></li>";
        }
        if (!$account_no) {
            $err = 1;
            $error .= "<li><b>Please key in Account No</b></li>";
        }
        if (!$branch) {
            $err = 1;
            $error .= "<li><b>Please key in Branch Name</b></li>";
        }
        if (!$account_type) {
            $err = 1;
            $error .= "<li><b>Please key in Account Type</b></li>";
        }
        if (!$swift_code) {
            $err = 1;
            $error .= "<li><b>Please key in Swift Code</b></li>";
        }
        if (!$route_no) {
            $err = 1;
            $error .= "<li><b>Please key in Route No</b></li>";
        }


        $error .= "</ul>";


        if ($err == 1) {
            exit(json_encode(array(
                'result' => 'error',
                'message' => $error,
            )));
        } else {

            $timestamp = Carbon::now()->timestamp;

            $bank_account = new BankAccount;
            $bank_account->account_name = $account_name;
            $bank_account->financial_organization_id = $bank;
            $bank_account->account_no = $account_no;
            $bank_account->branch = $branch;
            $bank_account->account_type = $account_type;
            $bank_account->swift_code = $swift_code;
            $bank_account->route_no = $route_no;

            $bank_account->save();


            exit(json_encode(array(
                'result' => 'success',
                't' => 'add',
                'message' => 'Bank Account Created Successfully !'
            )));

        }
    }


    public function editUsersById(Request $request)
    {

        $id = $request->id;
        $timestr = Carbon::now();
        $timestr = $timestr->toDateTimeString();


        if ($id != 0) {
            $foundUser = DB::table('users')->select('id', 'name', 'agent_id', 'email', 'password',
                'image')->where('id', $id)->first();
            $foundUserProperties = DB::table('user_property')->select('id', 'user_id', 'property_id')->where('user_id', $id)->get();

            exit(json_encode(array(
                'result' => 'success',
                'dataUser' => $foundUser,
                'dataUserProperties' => $foundUserProperties,
                'message' => 'Please edit Agent details!'
            )));

        } else {
            exit(json_encode(array(
                'result' => 'error',
                'message' => '<ul><li><b>Sorry, No Data :(</b></li>'
            )));


        }

    }

    public function updateUsersById(Request $request)
    {
        $timestr = Carbon::now();
        $timestr = $timestr->toDateTimeString();
        $timestamp = Carbon::now()->timestamp;

        $user_id = $request->id;
        $user = User::find($user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->agent_id = $request->agent_id;
        $hidden_user_image = $request->hidden_user_image;
        $property_name = explode(",", $request->property_name);

//dd($property_name);

        //for image uploading starts

        $imagefile = $request->user_image;

        if ($imagefile != "undefined") {
            $imagefilename = str_random(8) . '_' . $timestamp . '_' . $imagefile->getClientOriginalName();
            $imagefile->move(public_path() . '/images/', $imagefilename);
            $user->image = $imagefilename;
        } else {
            $user->image = $hidden_user_image;
        }

        //image uploading ends

//        $user->properties()->sync($property_name);

        UserProperty::where('user_id', $user_id)->delete();

        foreach ($property_name as $properties) {
            $userproperty = new UserProperty();
            $userproperty->property_id = $properties;
            $userproperty->user_id = $user_id;
            $userproperty->save();
        }

        $user->save();


        exit(json_encode(array(
            'result' => 'success',
            'message' => 'Successfully updated Agent!'
        )));


    }


    public function destroyUsersById(Request $request)
    {
        $user_id = $request->id;
        $del = User::find($user_id);
        $del->delete();

        $user_property = UserProperty::where('user_id', $user_id);
        $del_user_property = $user_property->delete();

        if ($del_user_property) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully deleted the Agent!'
            )));

        }
    }

}



