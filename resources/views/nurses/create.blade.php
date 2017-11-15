<div class="row">
    <div class="col-lg-12 ks-panels-column-section">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title">Create new Nurse</h5>
                {!! Form::open(['route' => 'nurses.store']) !!}

                @include('nurses.fields')

                {!! Form::close() !!}

            </div>
        </div>

    </div>
</div>