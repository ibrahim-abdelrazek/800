<div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach

            </ul>
        </div>
    @endif
</div>
<!--  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('name', 'Hotel name:',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">{!! Form::text('name', null, [  'class' => 'form-control']) !!}</div>
    
</div>


<!-- Officer Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('officer_name', 'Officer Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('officer_name', null, [  'class' => 'form-control']) !!}
    </div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_number', 'Contact Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('contact_number', null,  [  'style'=> 'padding-left:50px', 'maxlength'=> '10',  'class' => 'form-control phone-input', 'style' => 'padding-left: 100px;']) !!}
    </div>

</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('guest_room_number', 'Guest Room Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('guest_room_number', null, [  'class' => 'form-control']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('guest_first_name', 'Guest First Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('guest_first_name', null, [  'class' => 'form-control']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('guest_last_name', 'Guest Last Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">{!! Form::text('guest_last_name', null, [  'class' => 'form-control']) !!}</div>
</div>

<!--  Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('items', 'Items:') !!}</label>
    <div class="col-sm-10">{!! Form::text('items', null, [  'class' => 'form-control']) !!}</div>
</div>

@if(Auth::user()->isAdmin())
    <!--  Partner -->
    <div class="form-group row">
        <label for="default-input"
               class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            @if(\App\Partner::count() > 0)
                {!! Form::select('partner_id',App\Partner::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name', 'id'),null,['class' => 'form-control'])!!}
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
<div class="form-group row" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
        <a href="{!! route('hotelguest.index') !!}" class="btn btn-default"> Cancel</a>
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
        })(jQuery);

    </script>
@endpush