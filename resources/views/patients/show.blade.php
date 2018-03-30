@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class=""> patient </h3>
                    </div>

                    <div class="panel-body">

                        <div class="show">
                            <span>first name: </span>
                            <span class="value" >{{ $patient->first_name }}.{{ $patient->last_name}}</span>
                        </div>

                        <div class="show">
                            <span> last name:</span>
                            <span class="value" >{{ $patient->last_name}}</span>
                        </div>
                        <div class="show">
                            <span>date: </span>
                            <span class="value" >{{ $patient->date }}</span>
                        </div>

                         <div class="show">
                            <span>gender: </span>
                            <span class="value" >{{ $patient->gender }}</span>
                        </div>

                        <div class="show">
                            <span>contact_number: </span>
                            <span class="value" >{{'+' . $patient->contact_number }}</span>
                        </div>
                        <div class="show">
                            <span>email: </span>
                            <span class="value" >{{ $patient->email }}</span>
                            
                        </div>
                        <div class="show">
                            <span>insurance_card_details: </span>
                            <span class="value" >{{ $patient->insurance_card_details }}</span>
                            
                        </div>

                        <div class="show">
                            <span>notes: </span>
                            <span class="value" >{{ $patient->notes }}</span>
                        </div>


                        <div class="show">
                            <span> City:</span>
                            <span class="value" >{{ $patient->city->city_name }}</span>
                        </div>
                        <div class="show">
                            <span> Area:</span>
                            <span class="value" >{{ $patient->area->neighborhood_name }}</span>
                        </div>
                        <div class="show">
                            <span> Street:</span>
                            <span class="value" >{{ $patient->street }}</span>
                        </div>

                        @if($patient->villa_number)
                            <div class="show">
                                <span> Villa Number:</span>
                                <span class="value" >{{ $patient->villa_number }}</span>
                            </div>
                        @endif
                        @if($patient->apartment_number)
                            <div class="show">
                                <span> Apartment Number:</span>
                                <span class="value" >{{ $patient->apartment_number }}</span>
                            </div>
                        @endif
                        @if($patient->apartment_name)
                            <div class="show">
                                <span> Apartment Name:</span>
                                <span class="value" >{{ $patient->apartment_name }}</span>
                            </div>
                        @endif
                        @if($patient->office_number)
                            <div class="show">
                                <span> Office Number:</span>
                                <span class="value" >{{ $patient->office_number }}</span>
                            </div>
                        @endif
                        @if($patient->building_name)
                            <div class="show">
                                <span> Building Name:</span>
                                <span class="value" >{{ $patient->building_name }}</span>
                            </div>
                        @endif
                        @if($patient->company_name)
                            <div class="show">
                                <span> Company Name:</span>
                                <span class="value" >{{ $patient->company_name }}</span>
                            </div>
                        @endif



                        <div class="show">
                            <span>created at </span>
                            <span class="value" >{{ $patient->created_at }}</span>
                        </div>
                        <div class="show">
                            <span>updated at </span>
                            <span class="value" >{{ $patient->updated_at }}</span>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                @if($patient->insurance_file)
                                    <div class="show">
                                        <span style="float: left"> Insurance File:</span><br>
                                        <span class="value" >
                                            <a class="fancybox" href="<?= (empty($patient['insurance_file']))? '#' : $patient['insurance_file'];?>" target="_blank" data-fancybox-group="gallery" title="">
                                                @if(!empty($patient['insurance_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['insurance_file']), 'image') !== false)
                                                    <img src="<?= $patient['insurance_file'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                                                @elseif(!empty($patient['insurance_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['insurance_file']), 'pdf') !== false)
                                                    <img src="/upload/pdf.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                                                @else
                                                    <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                                                @endif
                                            </a>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($patient->id_file)
                                    <div class="show">
                                        <span style="float: left"> ID File:</span><br>
                                        <span class="value" >
                                            <a class="fancybox" href="<?= (empty($patient['id_file']))? '#' : $patient['id_file'];?>" target="_blank" data-fancybox-group="gallery" title="">
                                                @if(!empty($patient['id_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['id_file']), 'image') !== false)
                                                    <img src="<?= $patient['id_file'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                                                @elseif(!empty($patient['id_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['id_file']), 'pdf') !== false)
                                                    <img src="/upload/pdf.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                                                @else
                                                    <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                                                @endif
                                            </a>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <br>
                        <a href="{!! route('patients.index') !!}" class="btn btn-default pull-right">Back</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('customjs')
<script type="text/javascript" src="/assets/scripts/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
    $('.fancybox').fancybox();
</script>
@endpush