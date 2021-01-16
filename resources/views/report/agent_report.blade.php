

    @if(!empty($properties))

        <div class="container">
            <hr>
            <div class="row">
                <div class="col-md-8">

                    <span> Agent Name : {{$properties[0]->agent_name}} </span> </br>
                    <span> Agent ID : {{$properties[0]->agent_id}} </span> </br>
                    <span> Joining Date : {{ date('d-m-Y', strtotime($properties[0]->joining_date)) }}</span>

                </div>

                <div class="col-md-4">
                    <a href="{{ url('agent/report/export/'.$properties[0]->user_id) }}">Export Agent Report</a>

                </div>
            </div>
            <hr>
        </div>

        <form id="exportNew" method="" action="">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <td>SL.</td>
                <td>Property Name</td>
                <td>Address</td>
                <td>Property Details</td>
                <td>Property Status</td>
                <td>Signing Date</td>
                <td>Expiry Date</td>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; ?>
            @foreach($properties as $property)
                <tr id="role_row_{{$property->id}}">

                    <td> {{$i}} </td>
                    <td>{{{ $property->name }}}</td>
                    <td>{{{ $property->address }}}</td>
                    <td>{!!   "Size: ". $property->size. " </br>" ."Floor: ".$property->floor . "</br>". "Bed: " .$property->bed !!}</td>
                    <td>{{ $property->status_name }}</td>
                    <td>{{ date('d-m-Y', strtotime($property->signing_date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($property->expiry_date)) }}</td>

                </tr>
                <?php $i++;?>
            @endforeach
            </tbody>
        </table>

        </form>

    @endif





