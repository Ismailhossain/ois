@extends('layouts.master')
@section('script')
    <script src="assets/js/user/user.js"></script>

    <script type="text/javascript">
    </script>
@endsection
@section('title')
    @parent

    | Agent Management
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





    <button type="button" id="insertUser" class="btn btn-primary">Add Agent</button>
    <input type="hidden" id="user_edit_value" value="">
    <input type="hidden" id="all_image_url" name="all_image_url" value="{{ url('/') }}"/>


    <div id="ModalUser" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"
         aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog  modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Agent</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="NewUserSave" enctype="multipart/form-data" class="form-horizontal inline">
                        <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="">
                        <input type="hidden" name="hidden_user_image" id="hidden_user_image" value="">

                        <div class=" form-group">
                            <label for="name" class="col-sm-4 control-label">{{ __('Name') }}</label>

                            <div class="col-sm-6">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="agent_id" class="col-sm-4 control-label">{{ __('Agent ID') }}</label>

                            <div class="col-sm-6">
                                <input id="agent_id" type="text"
                                       class="form-control{{ $errors->has('agent_id') ? ' is-invalid' : '' }}"
                                       name="agent_id" value="{{ old('agent_id') }}">

                                @if ($errors->has('agent_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('agent_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="email" class="col-sm-4 control-label">{{ __('Email') }}</label>

                            <div class="col-sm-6">
                                <input id="email" type="text"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="property_title" class="col-sm-4 control-label">Property</label>

                            <div class="col-sm-6">
                                {{--<select name="roles" id="roles" class="form-control" >--}}
                                <select name="property_name[]" id="property_name" class="form-control"
                                        multiple="multiple">
                                    @foreach($properties as $property)
                                        <option value="{{$property->id}}">{{$property->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" form-group" id="hide_password">
                            <label for="password" class="col-sm-4 control-label">{{ __('Password') }}</label>

                            <div class="col-sm-6">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" value="{{ old('password') }}">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class=" form-group" id="hide_password_confirmation">
                            <label for="password_confirmation"
                                   class="col-sm-4 control-label">{{ __('Confirm Password') }}</label>

                            <div class="col-sm-6">
                                <input id="password_confirmation" type="password" class="form-control"
                                       name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group" id="RefreshUserFile">
                            <label for="user_image" class="col-sm-4 control-label">Image</label>

                            <div class="col-sm-6">
                                <input type="file" class="form-control" name="user_image" id="user_image">
                                <span id="user_image_url">
                                <span id="no_image_added1"></span>
                                <img style="width:60px; height: 60px" src="" id="my_user_image_url"/>
                            </span>
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
    </div>



    </br></br>


    <div id="refreshbody">


        <form method="get" enctype="multipart/form-data" class="form-horizontal inline">


            <table id="agentTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Agent ID</td>
                    <td>Email</td>
                    <td>Date Of Join</td>
                    <td>Image</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr id="user_row_{{$user->id}}">
                        <td>{{{ $user->name }}}</td>
                        <td>{{{ $user->agent_id }}}</td>
                        <td>{{{ $user->email }}}</td>
                        <td>{{{ $user->created_at }}}</td>
                        <td>
                            @if ($user->image)
                                <img src="{{ asset( '/images/' . $user->image)}}" style="width:60px;height:60px"
                                     class="img-polaroid" alt="">
                            @else
                                <img src="{{ asset( '/images/NoPicAvailable.png')}}" style="width:60px;height:60px"
                                     class="img-polaroid" alt="">

                            @endif

                        </td>
                        <td>
                            <input type='button' class="btn btn-small btn-info" id="edit_button<?php echo $user->id; ?>"
                                   value="Edit" onclick="edit_user('<?php echo $user->id; ?>');">
                            <input type='button' class="btn btn-small btn-danger"
                                   id="delete_button<?php echo $user->id; ?>"
                                   value="Delete" onclick="delete_user('<?php echo $user->id; ?>');">
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
                    <div class="pagination"> {!! str_replace('/?', '?', $users->render()) !!}
        </form>

    </div>




@endsection

