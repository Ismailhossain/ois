@extends('layouts.master')
@section('script')
    <script src="assets/js/property/property.js"></script>

    <script type="text/javascript">
    </script>
@endsection
@section('title')
    @parent

    | Property Management
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

        <button type="button" id="insertProperty" class="btn btn-primary" >Add Property</button>
        <input type="hidden" id="property_edit_value" value="" >


            <div id="ModalProperty" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                <div class="modal-dialog  modal-md">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Property</h4>
                        </div>

                        <div class="modal-body">
                            <form method="post" id="NewPropertySave"  enctype="multipart/form-data" class="form-horizontal inline" >

                            <div class=" form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-4 control-label">Name</label>

                                <div class="col-sm-6">
                                    <input id="name" required type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('owner_name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-4 control-label">Owner Name</label>

                                <div class="col-sm-6">
                                    <input id="owner_name" required type="text" class="form-control" name="owner_name" value="{{ old('owner_name') }}"  >

                                    @if ($errors->has('owner_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('owner_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group">
                                    <label for="owner_email" class="col-sm-4 control-label">Owner Email</label>

                                    <div class="col-sm-6">
                                        <input id="owner_email" type="email"
                                               class="form-control{{ $errors->has('owner_email') ? ' is-invalid' : '' }}" name="owner_email"
                                               value="{{ old('owner_email') }}">

                                        @if ($errors->has('owner_email'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('owner_email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                            </div>
                            <div class=" form-group">
                                <label for="owner_phone" class="col-sm-4 control-label">Owner Phone</label>

                                <div class="col-sm-6">
                                    <input id="owner_phone" type="text"
                                           class="form-control{{ $errors->has('owner_phone') ? ' is-invalid' : '' }}" name="owner_phone"
                                           value="{{ old('owner_phone') }}">

                                    @if ($errors->has('owner_phone'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('owner_phone') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-sm-4 control-label">Address</label>

                                <div class="col-sm-6">
                                    <input id="address"  type="text" class="form-control" name="address" value="{{ old('address') }}" >

                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('size') ? ' has-error' : '' }}">
                                <label for="size" class="col-sm-4 control-label">Size</label>

                                <div class="col-sm-6">
                                    <input id="size"  type="text" class="form-control" name="size" value="{{ old('size') }}" >

                                    @if ($errors->has('size'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('size') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('floor') ? ' has-error' : '' }}">
                                <label for="floor" class="col-sm-4 control-label">Floor</label>

                                <div class="col-sm-6">
                                    <input id="floor"  type="text" class="form-control" name="floor" value="{{ old('floor') }}" >

                                    @if ($errors->has('floor'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('floor') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('bed') ? ' has-error' : '' }}">
                                <label for="bed" class="col-sm-4 control-label">Bed</label>

                                <div class="col-sm-6">
                                    <input id="bed"  type="text" class="form-control" name="bed" value="{{ old('bed') }}" >

                                    @if ($errors->has('bed'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bed') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-sm-4 control-label">Price</label>

                                <div class="col-sm-6">
                                    <input id="price"  type="text" class="form-control" name="price" value="{{ old('price') }}" >

                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status_id" class="col-sm-4 control-label">{{ __('Status') }}</label>
                                <div class="col-sm-6">
                                    <select name="status_id" id="status_id" class="form-control">
                                        <option value="" selected disabled>Please select a Status</option>
                                        @foreach($status as $status_row)
                                            <option value="{{$status_row->status_id}}">{{$status_row->status_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('signing_date') ? ' has-error' : '' }}">
                                <label for="signing_date" class="col-sm-4 control-label">Signing Date</label>

                                <div class="col-sm-6">
                                    <input id="signing_date" required type="text" class="form-control" name="signing_date" value="{{ old('signing_date') }}" >

                                    @if ($errors->has('signing_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('signing_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class=" form-group{{ $errors->has('expiry_date') ? ' has-error' : '' }}">
                                <label for="expiry_date" class="col-sm-4 control-label">Expiry Date</label>

                                <div class="col-sm-6">
                                    <input id="expiry_date" required type="text" class="form-control" name="expiry_date" value="{{ old('expiry_date') }}" >

                                    @if ($errors->has('expiry_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('expiry_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="close_modal" data-dismiss="modal">Close</button>
                            <button type="reset" id="clear_modal" onclick="" class="btn btn-default">Clear</button>
                            <button type="submit" id="save_property_data" onclick="" class="btn btn-default">Save</button>
                        </div>
                    </form>
                    </div>

            </div>
            </div>



            </br></br>


    <div id="refreshbody">


        <form method="get" enctype="multipart/form-data" class="form-horizontal inline" >


    <table id="propertyTable" class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>Property Name</td>
            <td>Address</td>
            <td>Property Details</td>
            <td>Property Status</td>
            <td>Signing Date</td>
            <td>Expiry Date</td>
            <td>Actions</td>
        </tr>
        </thead>
        <tbody>
        @foreach($properties as $property)
            <tr id="role_row_{{$property->id}}">

                <td>{{{ $property->name }}}</td>
                <td>{{{ $property->address }}}</td>
                <td>{!!   "Size: ". $property->size. " </br>" ."Floor: ".$property->floor . "</br>". "Bed: " .$property->bed !!}</td>
                <td>{{ $property->status->status_name }}</td>
                <td>{{ date('d-m-Y', strtotime($property->signing_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($property->expiry_date)) }}</td>
                <td>
                    <input type='button' class="btn btn-small btn-info" id="edit_button<?php echo $property->id; ?>" value="Edit" onclick="edit_property('<?php echo $property->id; ?>');">
                    <input type='button' class="btn btn-small btn-danger" id="delete_button<?php echo $property->id; ?>" value="Delete" onclick="delete_property('<?php echo $property->id; ?>');">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
            <div class="pagination"> {!! str_replace('/?', '?', $properties->render()) !!}
        </form>
    </div>


@endsection


