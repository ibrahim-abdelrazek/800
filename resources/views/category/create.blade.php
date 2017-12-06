<div class="row">
    <div class="col-lg-12 ks-panels-column-section">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title">Create new Category</h5>
                {!! Form::open(['route' => 'category.store', 'files'=>true]) !!}

                @include('category.fields')

                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>