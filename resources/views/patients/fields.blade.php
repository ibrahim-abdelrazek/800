<div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger"><b>{{$error}}</b></li>
                @endforeach

            </ul>
        </div>
    @endif
</div>
<!--  first-Name -->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('first_name', 'First Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('first_name', null, [  'class' => 'form-control']) !!}
    </div>
</div>


<!--  last-Name -->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('last_name', 'Last Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('last_name', null, [  'class' => 'form-control']) !!}
    </div>
</div>


<!--  date -->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('date', 'Date:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::date('date',null,  [  'class' => 'form-control']) !!}</div>
</div>

<!-- gender-->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('gender', 'Gender:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::select('gender',['male' => 'male','female'=>'female' ],null, [  'class' => 'form-control']) !!}
    </div>
</div>


<!--  contact_number-->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('contact_number', 'Contact Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('contact_number',null, [ 'style'=> 'padding-left:50px', 'maxlength'=> '10',  'class' => 'form-control ks-phone-mask-input1']) !!}
        <span style="position: absolute;top: 10px;font-weight: bold;left: 23px;">(+971)</span>
    </div>
</div>


<!--  email-->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('email', 'Email:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::email('email',null, [  'class' => 'form-control']) !!}
    </div>
</div>

<!-- insurance_card_details-->
    <h4>Insurance Card Details</h4>
    <div class="form-group row" >
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('insurance_file', 'Upload Insurance File:',['class'=> 'required']) !!}</label>

        <div class="col-sm-10">
            @if(request()->route()->getAction()['as'] == "patients.edit")
                <a class="fancybox" href="<?= (empty($patient['insurance_file']))? '#' : $patient['insurance_file'];?>" target="_blank" data-fancybox-group="gallery" title="">
                    @if(!empty($patient['insurance_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['insurance_file']), 'image') !== false)
                        <img src="<?= $patient['insurance_file'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                    @elseif(!empty($patient['insurance_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['insurance_file']), 'pdf') !== false)
                        <img src="/upload/pdf.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                    @else
                        <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                    @endif
                </a>
            @endif
            {!! Form::file('insurance_file',null,  [  'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group row" >

        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('insurance card details', 'Insurance Provider:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            {!! Form::select('insurance_provider',App\InsuranceProvider::pluck('insurance_company','id'),null,['class' => 'form-control ks-select'])!!}
        </div>
    </div>

    <div class="form-group row" >
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('card_number', 'Card Number:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            {!! Form::text('card_number',null, [  'class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row" >
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('emirates id details', 'Insurance Expiry date:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            {!! Form::date('insurance_expiry',null, [  'class' => 'form-control']) !!}
        </div>
    </div>

<!-- emirates_id_details -->
<br />
<h4> Emirate ID Details</h4>
    <div class="form-group row" >
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('id_file', 'Upload ID File:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            @if(request()->route()->getAction()['as'] == "patients.edit")
                <a class="fancybox" href="<?= (empty($patient['id_file']))? '#' : $patient['id_file'];?>" target="_blank" data-fancybox-group="gallery" title="">
                    @if(!empty($patient['id_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['id_file']), 'image') !== false)
                        <img src="<?= $patient['id_file'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                    @elseif(!empty($patient['id_file']) && strpos(mime_content_type(base_path().'/public/'.$patient['id_file']), 'pdf') !== false)
                        <img src="/upload/pdf.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                    @else
                        <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                    @endif
                </a>
            @endif
            {!! Form::file('id_file',null,  [  'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group row" >
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('id_number', 'ID Number:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            {!! Form::text('id_number',null, [  'class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row" >
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('id_expiry', 'ID Expiry Date:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            {!! Form::date('id_expiry',null, [  'class' => 'form-control']) !!}
        </div>
    </div>
<br />
<h4>Address Details</h4>
<!-- notes-->

<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('notes', 'Notes:') !!}</label>
    <div class="col-sm-10">
        {!! Form::textarea('notes',null, [  'class' => 'form-control']) !!}
    </div>
</div>


<!-- address -->
<!-- address city-->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('address city', 'City:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::select('city',App\City::pluck('city_name','id'),null,['class' => 'form-control'])!!}
    </div>
</div>

<!-- address area-->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('address area', 'Area:',['class'=> 'required']) !!}</label>
    <div id="neighbors-holder" class="col-sm-10"></div>
</div>

<!-- address street-->
<div class="form-group row" >
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('address street', 'Street:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('street',null, [  'class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('address details', 'Address Details:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">

    {{ Form::radio('type1','home',false , ['class' => 'home' ]) }} Home
    &emsp;&emsp;
    {{ Form::radio('type1','office', false, ['class' => ' office' ]) }} Office
    </div>
</div>

<div class="form-group  row" id="office" style="display: none">
    <div class="col-sm-8 col-sm-offset-4">
    Company Name{!! Form::text('company_name',null, [  'class' => 'form-control compName']) !!}
    Building Name{!! Form::text('building_name',null, [  'class' => 'form-control buildName ']) !!}
    Office Number{!! Form::text('office_number',null, [  'class' => 'form-control officeNumber']) !!}
    </div>
</div>

<div class="form-group  row" id="home" style="display: none">
    <div class="col-sm-8 col-sm-offset-4">
    &emsp;&emsp; {{ Form::radio('type2','villa',false , ['class' => 'villa' ]) }} Villa
    &emsp;&emsp; &emsp;&emsp;
    &emsp;&emsp; {{ Form::radio('type2','apartment', false, ['class' => ' apartment' ]) }} Apartment
    </div>
</div>

<div class="form-group  row" id="villa" style="display: none">
    <div class="col-sm-8 col-sm-offset-4">
    &emsp;Villa Number{!! Form::text('villa_number',null, [ 'class' => 'form-control villaNumber']) !!}

    </div>
</div>
<div class="form-group  row" id="apartment" style="display: none">
    <div class="col-sm-8 col-sm-offset-4">
    Building Name {!! Form::text('apartment_name',null, [ 'class' => 'form-control apartmentName']) !!}
    Apartment Number{!! Form::text('apartment_number',null, [ 'class' => 'form-control apartmentNumber']) !!}
    </div>
</div>

@if(Auth::user()->isAdmin())
<!--  Partner -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner:') !!}</label>
        <div class="col-sm-10">

        @if(\App\Partner::count() > 0)
            {!! Form::select('partner_id',App\Partner::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name', 'id'),null,['class' => 'form-control'])!!}
        @else
            <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b class="label-danger">Add
                        new Partner</b></a></p>
        @endif
        </div>
</div>
<!-- End Partner -->
@endif


<br>

<!-- Submit Field -->
<div class="form-group row" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('patients.index') !!} " class="btn btn-default"> Cancel</a>
</div>



@push('customjs')
    @if($errors->any())
        <script>
            $(document).ready(function(){
                $("#create_new").click();
            });
        </script>
    @endif

<script src="{{ asset('libs/jquery-mask/jquery.mask.min.js') }}"></script><script type="text/javascript" src="/assets/scripts/fancybox/jquery.fancybox.pack.js"></script>
<script type="application/javascript">
    // asynchronous content
    (function ($) {
        $(document).ready(function () {
            $('.ks-phone-mask-input1').mask('000-0000#');
        });
    })(jQuery);

    $('.fancybox').fancybox();
</script>
@endpush


