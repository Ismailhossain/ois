@extends('layouts.master')
@section('script')
    <script src="assets/js/bank_account/bank_account.js"></script>

    <script type="text/javascript">
    </script>
@endsection
@section('title')
    @parent

    | Bank Account Management
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
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif





    <button type="button" id="insertUser" class="btn btn-primary">Add Bank Account</button>
    <input type="hidden" id="user_edit_value" value="">
    <input type="hidden" id="all_image_url" name="all_image_url" value="{{ url('/') }}"/>


    <div id="ModalUser" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"
         aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog  modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Bank Account</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="NewUserSave" enctype="multipart/form-data" class="form-horizontal inline">
                        <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="">
                        <input type="hidden" name="hidden_user_image" id="hidden_user_image" value="">

                        <div class=" form-group">
                            <label for="account_name" class="col-sm-4 control-label">{{ __('Account Name') }}</label>

                            <div class="col-sm-6">
                                <input id="account_name" type="text"
                                       class="form-control{{ $errors->has('account_name') ? ' is-invalid' : '' }}" name="account_name"
                                       value="{{ old('account_name') }}" autofocus>

                                @if ($errors->has('account_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank" class="col-sm-4 control-label">{{ __('Bank') }}</label>
                            <div class="col-sm-6">
                                <select name="bank" id="bank" class="form-control">
                                    <option value="" selected disabled>Please select a Bank</option>
                                    @foreach($financial_organizations as $financial_organization)
                                        <option value="{{$financial_organization->id}}">{{$financial_organization->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="account_no" class="col-sm-4 control-label">{{ __('Account No') }}</label>

                            <div class="col-sm-6">
                                <input id="account_no" type="text"
                                       class="form-control{{ $errors->has('account_no') ? ' is-invalid' : '' }}"
                                       name="account_no" value="{{ old('account_no') }}">

                                @if ($errors->has('account_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="branch" class="col-sm-4 control-label">{{ __('Branch') }}</label>

                            <div class="col-sm-6">
                                <input id="branch" type="text"
                                       class="form-control{{ $errors->has('branch') ? ' is-invalid' : '' }}" name="branch"
                                       value="{{ old('branch') }}">

                                @if ($errors->has('branch'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('branch') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="account_type" class="col-sm-4 control-label">{{ __('Account Type') }}</label>
                            <div class="col-sm-6">
                                <select name="account_type" id="account_type" class="form-control">
                                    <option value="" selected disabled>Please select a Account Type</option>
                                    @foreach($account_types as $account_type)
                                        <option value="{{$account_type->id}}">{{$account_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="swift_code" class="col-sm-4 control-label">{{ __('Swift Code') }}</label>

                            <div class="col-sm-6">
                                <input id="swift_code" type="text"
                                       class="form-control{{ $errors->has('swift_code') ? ' is-invalid' : '' }}" name="swift_code"
                                       value="{{ old('swift_code') }}">

                                @if ($errors->has('swift_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('swift_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="route_no" class="col-sm-4 control-label">{{ __('Route No') }}</label>

                            <div class="col-sm-6">
                                <input id="route_no" type="text"
                                       class="form-control{{ $errors->has('route_no') ? ' is-invalid' : '' }}" name="route_no"
                                       value="{{ old('route_no') }}">

                                @if ($errors->has('route_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('route_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="reset" id="clear_modal" onclick="" class="btn btn-default">Clear</button>
                    <button type="submit" id="save_user_data" onclick="" class="btn btn-default">Save</button>
                </div>
                </form>
            </div>

        </div>
    </div>x`



    </br></br>


    <div id="refreshbody">


        <form method="get" enctype="multipart/form-data" class="form-horizontal inline">


            <table id="agentTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Account Name</td>
                    <td>Bank</td>
                    <td>Account No</td>
                    <td>Branch</td>
                    <td>Account Type</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($bank_accounts as $bank_account)
                    <tr id="user_row_{{$bank_account->id}}">
                        <td>{{{ $bank_account->account_name }}}</td>
                        <td>{{ isset($bank_account->bank->name) ? $bank_account->bank->name : 'N/A' }}</td>
                        <td>{{{ $bank_account->account_no }}}</td>
                        <td>{{{ $bank_account->branch }}}</td>
                        <td>{{ isset($bank_account->account_type->name) ? $bank_account->account_type->name : 'N/A' }}</td>
                        <td>
                            <input type='button' class="btn btn-small btn-info" id="edit_button<?php echo $bank_account->id; ?>"
                                   value="Edit" onclick="edit_user('<?php echo $bank_account->id; ?>');">
                            <input type='button' class="btn btn-small btn-danger"
                                   id="delete_button<?php echo $bank_account->id; ?>"
                                   value="Delete" onclick="delete_user('<?php echo $bank_account->id; ?>');">
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
                    <div class="pagination"> {!! str_replace('/?', '?', $bank_accounts->render()) !!}
        </form>

    </div>




@endsection

