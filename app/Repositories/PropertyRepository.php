<?php


namespace App\Repositories;

use App\Property;
use App\Status;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class PropertyRepository
{


    /**
     * Role constructor.
     */
    public function __construct(Property $property)

    {


    }

    public function index()
    {

//        $properties = Property::with('status')->get();
        $properties = Property::with('status')->paginate(10);
        $status = Status::all();
        return view('property.index', compact('properties', 'status'));
    }


    public function storeProperties($request)
    {


        $PropertyName = $request->name;
        $slug = str_replace('/', '-', str_replace(' ', '-', str_replace('&', '', str_replace('?', '', strtolower($PropertyName)))));

        if ($request->signing_date) {
            $signing_date = date('Y-m-d', strtotime($request->signing_date));
        }
        if ($request->expiry_date) {
            $expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        }

        $validator = Validator::make($request->all(), [
                'name' => 'required',

            ]

        );
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            exit(json_encode(array(
                'result' => 'error',
                'message' => $errors,
            )));

        } //            ) );
        else {
            $property = new Property;
            $property->name = $request->name;
            $property->slug = $slug;
            $property->owner_name = $request->owner_name;
            $property->owner_email = $request->owner_email;
            $property->owner_phone = $request->owner_phone;
            $property->address = $request->address;
            $property->size = $request->size;
            $property->floor = $request->floor;
            $property->bed = $request->bed;
            $property->price = $request->price;
            $property->status_id = $request->status_id;
            $property->signing_date = $signing_date;
            $property->expiry_date = $expiry_date;

            $property->save();

            //Get the property ID created just now

            $new_property = $property->id;

            exit(json_encode(array(
                'result' => 'success',
                't' => 'add',
                'message' => 'Property Created Successfully !'
            )));

            return response()->json(array('Result' => $property), 201);
        }


    }


    public function editPropertyById(Request $request)
    {

        $id = $request->id;

        if ($id != 0) {
            $foundProperty = DB::table('properties')->select('*')->where('id', $id)->first();

            exit(json_encode(array(
                'result' => 'success',
                'dataProperty' => $foundProperty,
//                'dataRolePermissions' => $foundRolePermissions,
                'message' => 'Please Edit Property Details!'
            )));

        } else {
            exit(json_encode(array(
                'result' => 'error',
                'message' => '<ul><li><b>Sorry, No Data :(</b></li>'
            )));


        }

    }


    public function updatePropertyById(Request $request)
    {

        if ($request->signing_date) {
            $signing_date = date('Y-m-d', strtotime($request->signing_date));
        }
        if ($request->expiry_date) {
            $expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        }
        $property_id = $request->id;
        $property = Property::find($property_id);
        $property->name = $request->name;
        $property->owner_name = $request->owner_name;
        $property->owner_email = $request->owner_email;
        $property->owner_phone = $request->owner_phone;
        $property->address = $request->address;
        $property->size = $request->size;
        $property->floor = $request->floor;
        $property->bed = $request->bed;
        $property->price = $request->price;
        $property->status_id = $request->status_id;
        $property->signing_date = $signing_date;
        $property->expiry_date = $expiry_date;


//        $property->permissions()->sync(Input::get('permission'));

        $update = $property->save();

        if ($update) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully Updated the property!'
            )));

        }
    }

    public function destroyPropertyById(Request $request)
    {
        $property_id = $request->id;
        $property = Property::find($property_id);
        $del = $property->delete();


        if ($del) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully deleted the Property!'
            )));

        }
    }


}



