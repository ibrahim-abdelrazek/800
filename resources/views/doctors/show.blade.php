<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class=""> doctor </h3>
                </div>

                <div class="panel-body">

                    <div class="show">
                        <span>Name: </span>
                        <span class="value">{{ $doctor->first_name ." ". $doctor->last_name }}  </span>
                    </div>

                    <div class="show">
                        <span>specialty: </span>
                        <span class="value">{{ $doctor->specialty }}</span>
                    </div>
                    <div class="show">
                        <span>contact_details: </span>
                        <span class="value">{{ $doctor->contact_details }}</span>
                    </div>
                    <div class="show">
                        <span>created at: </span>
                        <span class="value">{{ $doctor->created_at }}</span>
                    </div>
                    <div class="show">
                        <span>updated at: </span>
                        <span class="value">{{ $doctor->updated_at }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
