@extends('layouts.master')

@section('script')
    <script src="assets/js/report/report.js"></script>

    <script type="text/javascript">
    </script>
@endsection
@section('title')
    @parent

    | Report Management
@endsection

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($errors))
        <div class="alert-danger">


            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach


        </div>
    @endif
    @if (Session::has('message'))
        <div class="alert alert-info ">{{ Session::get('message') }}</div>
    @endif


    <div>
        <form class="form-inline d-flex justify-content-center md-form form-sm">
            <span> Agent :   <input id="agentName" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Type for Agent"
                                    aria-label="Search"> </span>
            {{--            <button id="refresh" class="btn btn-default" type="button"><span class="fa fa-refresh" aria-hidden="true"></span></button>--}}
        </form>
    </div>


    <div class="per_agent_report">

    </div>




@endsection
