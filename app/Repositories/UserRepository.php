<?php


namespace App\Repositories;

use Illuminate\Http\Response;
use App\User;
use App\Property;
use App\UserProperty;
use App\Status;
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

class UserRepository
{


    /**
     * User constructor.
     */
    public function __construct(User $user)

    {

    }

    public function index()
    {
//        $users = User::all();
        $properties = Property::all();
        $users = User::paginate(10);
        return view('user.index', compact('users', 'properties'));
    }


    public function storeUsers(Request $request)
    {

        $name = $request->name;
        $agent_id = $request->agent_id;
        $email = $request->email;
        $property_name = explode(",", $request->property_name);
        $password = $request->password;
        $passwordlen = strlen($password);
        $password_confirmation = $request->password_confirmation;

        $err = "";


        $error = "<ul>";

        if (!$name) {
            $err = 1;
            $error .= "<li><b>Please key in Name</b></li>";
        }
        if (!$agent_id) {
            $err = 1;
            $error .= "<li><b>Please key in Username</b></li>";
        }
        if (!$email) {
            $err = 1;
            $error .= "<li><b>Please key in Email</b></li>";
        } else {

            $FoundDupEmail = DB::table('users')->select('email')->where('email', $email)->first();
            if ($FoundDupEmail) {
                $err = 1;
                $error .= "<li><b>Please key in valid Email. Duplicate Email found.</b></li>";
            }
        }

        foreach ($property_name as $key => $value) {
            if (empty($value)) {
                $err = 1;
                $error .= "<li><b>Please select Property</b></li>";
            }
        }
        if (!$password && $passwordlen != 6) {
            $err = 1;
            $error .= "<li><b>Please key in 6 digit Password</b></li>";
        }

        if ($password != $password_confirmation) {
            $err = 1;
            $error .= "<li><b>Please key in Same Password</b></li>";
        }


        $error .= "</ul>";


        if ($err == 1) {
            exit(json_encode(array(
                'result' => 'error',
                'message' => $error,
            )));
        } else {

            $timestamp = Carbon::now()->timestamp;

            $user = new User;
            $user->name = $name;
            $user->agent_id = $agent_id;
            $user->email = $email;
            $user->password = Hash::make($password);


            //for image uploading starts

            $imagefile = $request->user_image;
//            dd($imagefile);
            if ($imagefile != "undefined") {

                // To explode from ajax request

                $imagefilename = str_random(8) . '_' . $timestamp . '_' . $imagefile->getClientOriginalName();

                $imagefile->move(public_path() . '/images/', $imagefilename);

//        }


                $user->image = $imagefilename;
            } else {

                $user->image = '';

            }
            //image uploading ends

            $user->save();

            //Get the user ID created just now

            $new_user = $user->id;

            foreach ($property_name as $properties) {
                $userproperty = new UserProperty();
                $userproperty->property_id = $properties;
                $userproperty->user_id = $new_user;
                $userproperty->save();
            }


            exit(json_encode(array(
                'result' => 'success',
                't' => 'add',
                'message' => 'Agent Created Successfully !'
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



