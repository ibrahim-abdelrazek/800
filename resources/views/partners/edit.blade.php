@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Edit Partner</h5>

                    {!! Form::model($partner, ['route' => ['partners.update', $partner['id']],'files'=>true, 'method' => 'patch']) !!}

                    @include('partners.fields')

                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div>
@endsection

@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {
            $('label[for="logo"]').removeClass('required');
            $('label[for="password"]').removeClass('required');
            $('label[for="password_confirmation"]').removeClass('required');

        });
    </script>
@endpush

