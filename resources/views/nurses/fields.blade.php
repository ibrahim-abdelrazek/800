<div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="alert alert-danger alert-dismissable">{{$error}}</li>
                @endforeach

            </ul>
        </div>
    @endif
</div>
<!--  first Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('first_name', 'First Name:' ,['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('first_name', null, [  'placeholder'=>'Enter Nurse\'s first name', 'class' => 'form-control', 'required']) !!}
    </div>
</div>

<!--  last Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('last_name', 'Last Name:' ,['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('last_name', null, [  'placeholder'=>'Enter Nurse\'s last name', 'class' => 'form-control', 'required']) !!}
    </div>
</div>


<div class="form-group row">

    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('photo', 'Upload Nurse\'s Photo (Optional):') !!}</label>
    <div class="col-sm-10">
        @if(request()->route()->getAction()['as'] == "nurses.edit")
            <a class="fancybox" href="<?= (empty($nurse['photo']))? '#' : $nurse['photo'];?>" target="_blank" data-fancybox-group="gallery" title="">
                @if(!empty($nurse['photo']))
                    <img src="<?= $nurse['photo'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                @else
                    <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                @endif
            </a>
        @endif
        {!! Form::file('photo',null,  [  'class' => 'form-control']) !!}
    </div>
</div>
<!--  contact -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_email', 'Contact Email:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::email('contact_email', null, [  'placeholder'=>'Enter Nurse\'s Contact Email', 'class' => 'form-control', 'required']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_number', 'Contact Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">

        {!! Form::text('contact_number', null, [  'placeholder'=>'Enter Nurse\'s Number','style'=> 'padding-left:50px', 'maxlength'=> '10', 'class' => 'form-control phone-input' , 'required', 'style' => 'padding-left: 100px;']) !!}

    </div>
</div>

@if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
    <!--  Partner -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            @if(\App\Partner::count() > 0)
                {!! Form::select('partner_id',
                App\Partner::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name', 'id')
                ,null,['class' => 'form-control'])!!}
            @else
                <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b
                                class="label-danger">Add
                            new Partner</b></a></p>
            @endif
        </div>
    </div>
    <!-- End Partner -->
@endif

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
    @if(\App\Partner::count() > 0)
        {!! Form::submit('Save', ['class' => 'btn btn-large btn-success']) !!}
    @else
        {!! Form::submit('Save', ['disabled', 'class' => 'btn btn-large btn-success']) !!}
    @endif

    @if(!empty($edit))
        <a id="back" class="btn btn-default" href="{{ route('nurses.index') }}" >back</a>
    @else
        <button id="reset" class="btn btn-default" type="button">Reset</button>
    @endif

</div>

@push('customcss')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/international-telephone-input/css/intlTelInput.css') }}">
@endpush

@push('customjs')
<script src="{{ asset('libs/international-telephone-input/js/intlTelInput.min.js') }}"></script>
<script type="application/javascript">
    // asynchronous content
    (function ($) {
        $(document).ready(function () {
            $(".phone-input").intlTelInput({
                autoHideDialCode: false,
                formatOnDisplay: true,
                hiddenInput: "full_number",
                initialCountry: "ae",
                nationalMode: true,
                preferredCountries : ['ae'],
                separateDialCode: true,
                utilsScript: "{{asset("libs/international-telephone-input/js/utils.js")}}"
            });
        });
        $('.fancybox').fancybox();
    })(jQuery);


</script>
@endpush