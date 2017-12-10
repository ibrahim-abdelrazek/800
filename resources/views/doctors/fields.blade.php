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
<!--  First Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('first_name', 'First Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('first_name', null, [  'class' => 'form-control']) !!}
    </div>
</div>
<!-- last Name -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('last_name', 'Last Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('last_name', null, [ 'class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">

    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('photo', 'Upload Doctor\'s Photo (Optional):') !!}</label>
    <div class="col-sm-10">
        @if(request()->route()->getAction()['as'] == "doctors.edit")
            <a class="fancybox" href="<?= (empty($doctor['photo']))? '#' : $doctor['photo'];?>" target="_blank" data-fancybox-group="gallery" title="">
                @if(!empty($doctor['photo']))
                    <img src="<?= $doctor['photo'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                @else
                    <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                @endif
            </a>
        @endif
        {!! Form::file('photo',null,  [  'class' => 'form-control']) !!}
    </div>
</div>
<!--  specialty -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('specialty', 'Specialty:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('specialty', null, [
        'placeholder'=>'Enter Doctor Specialities',
        'class' => 'flexdatalist form-control',
        'data-min-length' => '1',
        'list' => 'ks-flexdatalist-specialities'
        ]) !!}

        <datalist id="ks-flexdatalist-specialities">
            @foreach($specialites as $speciality)
                <option value="{{ $speciality }}">{{ $speciality }}</option>
            @endforeach
        </datalist>
    </div>

</div>
<!--  contact -->
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_email', 'Contact Email:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::email('contact_email', null, [  'placeholder'=>'Enter Doctor\'s Contact Email', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="default-input"
           class="col-sm-2 form-control-label">{!! Form::label('contact_number', 'Contact Number:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('contact_number', null, [  'placeholder'=>'Enter Doctor\'s Number','style'=> 'padding-left:50px', 'maxlength'=> '10',  'class' => 'form-control phone-input', 'style' => 'padding-left: 100px;']) !!}
    </div>
</div>

@if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
    <!--  Partner -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">{!! Form::label('partner', 'partner',['class'=> 'required']) !!}</label>
        <div class="col-sm-10">
            @if(\App\Partner::count() > 0)
                {!! Form::select('partner_id',App\Partner::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name', 'id'),null,['style'=>'width:100% !importnat','class' => 'form-control'])!!}
            @else
                <p>You don't have added partners yet, Please <a href="{{route('partners.index')}}"><b
                                class="label-danger">Add
                            new Partner</b></a></p>
            @endif
        </div>
    </div>
    <!-- End Partner -->
@endif
<!-- Nurse -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('Nurse', 'Nurse:',['class'=> 'required']) !!}</label>
    <div id="nurses-holder" class="col-sm-10">
        @if(isset($doctor))
            @php $i=1; $nurses = $doctor->nurses; @endphp
            @foreach($nurses as $nurse)
                <?php $nursesArr[] = $nurse->id;?>
            @endforeach
            @foreach($nurses as $nurse)
            <div class="row">
                <div class="col-md-10">
                    <?php $allNurses = App\Nurse::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->where('partner_id', $doctor['partner_id'])->pluck('name', 'id'); ?>
                    <select name="nurses[]" style="width:100% !importnat" class="form-control">
                        @foreach($allNurses as $key => $value)
                            @if($key == $nurse->id || !in_array($key, $nursesArr))
                                <option value="{{$key}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                      {{--{!! Form::select('nurses[]',App\Nurse::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->where('partner_id', $doctor['partner_id'])->pluck('name', 'id'),$nurse->id,['style'=>'width:100% !importnat','class' => 'form-control'])!!}--}}
                </div> 
                <div class="col-sm-2">
                    @if($i == 1 )
                    <a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field">
                        <span class="la la-plus-circle la-2x"></span> 
                    </a>
                    @else
                    <a href="javascript:void(0);" style="padding-top:6px;" class=" remove_button btn btn-danger" title="Remove field"><span class="la la-minus-circle la-2x"></span> </a>
                    @endif
                    @php($i++)
                    </div>
                </div> 
            @endforeach
        @endif
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>
    @if(\App\Nurse::count() > 0 && \App\Partner::count() > 0)
        {!! Form::submit('Save', ['class' => 'btn btn-large btn-success']) !!}
    @else
        {!! Form::submit('Save', ['disabled', 'class' => 'btn btn-large btn-success']) !!}
    @endif

    @if(!empty($edit))
            <a id="back" class="btn btn-default" href="{{ route('doctors.index') }}" >back</a>
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

            $('.fancybox').fancybox();
        });
    </script>
@endpush







