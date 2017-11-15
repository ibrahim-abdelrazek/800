@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Create new Patient</h5>

                        {!! Form::open(['route' => 'patients.store']) !!}

                            @include('patients.fields')

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
@endsection
@push('customjs')
    <script type="text/javascript">
        $(document).ready(function() {

            $(".office").on("click", function () {

                $('#office').css("display", 'block');
                $('#home').css("display", 'none');

                $('#apartment').css("display", 'none');
                $('#villa').css("display", 'none');

            /*    $(".apartmentName").val('');
               $(".apartmentNumber").val('');
                $(".villaNumber").val('');*/

            });

            $(".home").on("click", function () {

                $('#home').css("display", 'block');
                $('#office').css("display", 'none');


                $(".villa").on("click", function () {

                    $('#villa').css("display", 'block');
                    $('#apartment').css("display", 'none');
/*
                    $(".compName").val('');
                    $(".buildName").val('');
                    $(".officeNumber").val('');
                    $(".apartmentName").val('');
                    $(".apartmentNumber").val('');*/
                });


                $(".apartment").on("click", function () {

                    $('#apartment').css("display", 'block');
                    $('#villa').css("display", 'none');

                   /* $(".compName").val('');
                    $(".buildName").val('');
                    $(".officeNumber").val('');
                    $(".villaNumber").val('');*/

                });
            });

        });


    </script>
@endpush