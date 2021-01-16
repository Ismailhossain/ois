<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Property;
use App\User;
use App\Status;
use App\Repositories\ReportRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class ReportController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportRepository $reportRepository)
    {
//        $this->middleware('auth');
        $this->reportRepository = $reportRepository;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->reportRepository->index();
    }

    /**
     * Show the autosearch result.
     *
     * @return \Illuminate\Http\Response
     */
    public function nameSearch(Request $request)
    {
        return $this->reportRepository->nameSearch($request);
    }

    /**
     * Display per agent property.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agentReport(Request $request)
    {

        return $this->reportRepository->agentReport($request);

    }

    /**
     * Export the property per agent
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agentReportExport(Request $request, $ID)
    {
        return $this->reportRepository->agentReportExport($request,$ID);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->reportRepository->updateReportById($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->reportRepository->destroyReportById($request);

    }










}
