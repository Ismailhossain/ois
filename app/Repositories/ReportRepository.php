<?php


namespace App\Repositories;
use App\User;
use App\Property;
use App\UserProperty;
use App\Status;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class ReportRepository
{

    public $successStatus = 200;

    /**
     * Role constructor.
     */
    public function __construct()

    {


    }

    public function index(){
//        $users =  User::all();
        return view('report.index');
    }


    public function nameSearch(Request $request){

        $search = $request->search;
//        dd($search);

        if($search == ''){
            $users = DB::table('users')
                ->select('*')
                ->where('name', 'like', '%' .$search . '%')
                ->get();
        }else{
            $users = DB::table('users')
                ->select('*')
                ->where('name', 'like', '%' .$search . '%')
                ->get();
        }
//        dd($users);
        $response = array();
        foreach($users as $user){
            $response[] = array("label"=>$user->name,"user_id"=>$user->id);
        }

        echo json_encode($response);
        exit;
    }


    public function agentReport(Request $request) {

        $user_id = $request->id;
        $properties = DB::table('user_property')
            ->join('properties','user_property.property_id','=','properties.id')
            ->join('users','user_property.user_id','=','users.id')
            ->join('status','status.status_id','=','properties.status_id')
            ->select('properties.*','user_property.id','users.id AS user_id','users.name AS agent_name','users.agent_id','users.created_at As joining_date','status.status_name')
            ->where('user_property.user_id', $user_id)
            ->orderBy('user_property.id','asc')
            ->get();

//        dd($properties);

        $view = view('report.agent_report', compact('properties'));
        $html = $view->render();

        exit(json_encode(array(
            'result' => 'success',
            'dataProperty' => $html,
            'message' => 'Agent Selected Successfully !'
        )));


    }

    public function agentReportExport(Request $request, $ID){

//        $user_id = $request->id;
        $user_id = request()->segment(4);
        $properties_data = DB::table('user_property')
            ->join('properties','user_property.property_id','=','properties.id')
            ->join('users','user_property.user_id','=','users.id')
            ->join('status','status.status_id','=','properties.status_id')
            ->select('properties.*','user_property.id','users.name AS agent_name','users.agent_id','users.created_at As joining_date','status.status_name')
            ->where('user_property.user_id', $user_id)
            ->get()
            ->toArray();
        $properties_array[] = array('SL.','Agent Name','Agent ID','Agent Joining Date', 'Property Name', 'Address','Size','Floor','Bed',
            'Status','Sigining Date', 'Expiry Date');
        $i = 1;
        foreach ($properties_data as $property) {
            $properties_array[] = array(

                'SL.' => $i++,
                'Agent Name' => $property->agent_name,
                'Agent ID' => $property->agent_id,
                'Agent Joining Date' => date('d-m-Y', strtotime($property->joining_date)),
                'Property Name' => $property->name,
                'Address' => $property->address,
                'Size' => $property->size,
                'Floor' => $property->floor,
                'Bed' => $property->bed,
                'Status' => $property->status_name,
                'Sigining Date' => date('d-m-Y', strtotime($property->signing_date)),
                'Expiry Date' => date('d-m-Y', strtotime($property->expiry_date))
            );

        }


        //create excel
        return   \Excel::create('Agent Report', function($excel) use($properties_array) {
            $excel->sheet('Agent Report', function($sheet) use($properties_array) {
                $sheet->fromArray($properties_array);
            });
        })->download('xlsx');

    }



}



