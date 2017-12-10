
@push('customcss')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/styles/token-input.css') }}">
@endpush
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
<!--  prescription -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('prescription', 'Prescription:',['class'=> 'required']) !!}
    </label>

    <div class="col-sm-10">
        @if(request()->route()->getAction()['as'] == "orders.edit")
            <a class="fancybox" href="<?= (empty($order['prescription']))? '#' : $order['prescription'];?>" target="_blank" data-fancybox-group="gallery" title="">
                @if(!empty($order['prescription']) && file_exists(base_path().'/public/'.$order['prescription']) && strpos(mime_content_type(base_path().'/public/'.$order['prescription']), 'image') !== false)
                    <img src="<?= $order['prescription'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                @elseif(!empty($order['prescription']) && file_exists(base_path().'/public/'.$order['prescription']) && strpos(mime_content_type(base_path().'/public/'.$order['insurance_file']), 'pdf') !== false)
                    <img src="/upload/pdf.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                @else
                    <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                @endif
            </a>
        @endif
        {!! Form::file('prescription',null,  [  'class' => 'form-control']) !!}
    </div>

</div>
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('insurance_claim', 'Insurance Claim:',['class'=> 'required']) !!}
    </label>

    <div class="col-sm-10">
        @if(request()->route()->getAction()['as'] == "orders.edit")
            <a class="fancybox" href="<?= (empty($order['insurance_claim']))? '#' : $order['insurance_claim'];?>" target="_blank" data-fancybox-group="gallery" title="">
                @if(!empty($order['insurance_claim']) && file_exists(base_path().'/public/'.$order['insurance_claim']) && strpos(mime_content_type(base_path().'/public/'.$order['insurance_claim']), 'image') !== false)
                    <img src="<?= $order['insurance_claim'];?>" style="width:150px; height:150px; float: left;margin-right:25px;">
                @elseif(!empty($order['insurance_claim']) && file_exists(base_path().'/public/'.$order['insurance_claim']) && strpos(mime_content_type(base_path().'/public/'.$order['insurance_file']), 'pdf') !== false)
                    <img src="/upload/pdf.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                @else
                    <img src="/upload/doc.png" style="width:75px; height:75px; float: left;margin-right:25px;">
                @endif
            </a>
        @endif
        {!! Form::file('insurance_claim',null,  [  'class' => 'form-control']) !!}
    </div>

</div>

<!-- notes -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('notes', 'Notes:') !!}
    </label>
    <div class="col-sm-10">
        {!! Form::textarea('notes',null, [  'class' => 'form-control']) !!}
    </div>
</div>

@if(!Auth::user()->isAdmin() && !Auth::user()->isCallCenter())

    <!--  patient_id -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('patient', 'Patient:',['class'=> 'required']) !!}
        </label>

        <div class="col-sm-10">

{!! Form::text('patient_id',null, [ 'id'=>'search', 'class' => 'form-control']) !!}
 <!-- @if(\App\Patient::where('partner_id', Auth::user()->partner_id)->count() > 0)

                {!! form::select ('patient_id',App\Patient::select(DB::raw("CONCAT(first_name,' ', last_name) AS full_name, id"))->where('partner_id', Auth::user()->partner_id)->pluck('full_name','id'),null,['class' => 'form-control'])!!}
            @else
                <p>You don't have added patients yet, Please <a href="{{route('patients.index')}}"><b class="label-danger">Add
                            new Patient</b></a></p>
            @endif -->
        </div>
    </div>
    <!-- Doctor -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('doctor', 'Doctor',['class'=> 'required']) !!}
        </label>

        <div class="col-sm-10">
            @if(\App\Doctor::where('partner_id', Auth::user()->partner_id)->count() > 0)

                {!! form::select ('doctor_id',App\Doctor::select(DB::raw("CONCAT(first_name,' ', last_name) AS name,id "))->where('partner_id', Auth::user()->partner_id)->pluck('name','id'),null,['class' => 'form-control'])!!}
            @else
                <p>You don't have added doctors yet, Please <a href="{{route('doctors.index')}}"><b class="label-danger">Add
                            new Doctor</b></a></p>
            @endif
        </div>
    </div>


@else
    <!--  partner_id -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('partner', 'Partner',['class'=> 'required']) !!}
        </label>

        <div class="col-sm-10">
            {!! Form::select('partner_id',App\Partner::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')->pluck('name', 'id'),null,['class' => 'form-control','id'=>'partner_id'])!!}
        </div>
    </div>
    <!-- Patients Holder -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('patient', 'Patient',['class'=> 'required']) !!}
        </label>

        <div id="patients-holder" class="col-sm-10">
            {!! Form::text('patient_id',null, [ 'id'=>'search', 'class' => 'form-control']) !!}
        </div>
    </div>
    <!--  doctor_id -->
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('doctor', 'Doctor',['class'=> 'required']) !!}
        </label>
        <div id="doctors-holder" class="col-sm-10">
            {!! form::select ('doctor_id',App\Doctor::select(DB::raw("CONCAT(first_name,' ', last_name) AS name,id "))->where('partner_id', Auth::user()->partner_id)->pluck('name','id'),null,['class' => 'form-control '])!!}
        </div>
    </div>
@endif
<!--  product_id -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('product', 'Product',[]) !!}
    </label>

    <div id="products_wrapper" class="col-sm-10">
        @if(isset($order))
            @php $k=1; $products = $order->products; @endphp
            @if(count($products) > 0)
                @foreach($products as $key => $val)
                    <div class="form-group row">
                        <div class="col-sm-3">

                            {!! form :: select ('products[]',App\Product::pluck('name','id'),$key,['id'=>'products-holder', 'class' => 'select2 form-control'])!!}

                        </div>
                    <div class="text-center col-sm-1">
                        <span class="label label-danger">X</span>
                    </div>
                    <div class="col-sm-3">
                        {!! Form::text('quantities[]', $val, [  'placeholder'=>'Enter Product\'s quantity','id'=>'products-holder',  'class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-3">
                        @php
                            $cop[-1] = 'Select Co-Payments';
                        @endphp
                        @for($i = 0; $i <= 35; $i=$i+5)
                            @php $cop[$i] = $i; @endphp
                        @endfor
                        {!! Form::select('copayments[]', $cop, $order->copayments[$key], ['class' => 'select2 form-control']) !!}
                        
                    </div>
                    <div class="col-sm-2">
                        @if($k == 1 )
                        <a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field"><span class="la la-plus-circle la-2x"></span> </a>
                        @else
                            <a href="javascript:void(0);" style="padding-top:6px;" class=" remove_button btn btn-danger" title="Remove field"><span class="la la-minus-circle la-2x"></span> </a>
                        @endif
                            @php $k++; @endphp

                    </div>
                </div>
                @endforeach
            @else
                <div class="form-group row">
                @php 
                    $prods = App\Product::pluck('name','id')->toArray();
                    $prods[] = ['0' => 'Select Product'];
                @endphp    

                 <div class="col-sm-3">
                     {!! form :: select ('products[]',$prods,0,['id'=>'products-holder', 'class' => 'select2 form-control'])!!}

                 </div>
                 <div class="text-center col-sm-1">
                     <span class="label label-danger">X</span>
                 </div>
                 <div class="col-sm-3">
                     {!! Form::text('quantities[]', null, [  'placeholder'=>'Enter Product\'s quantity', 'class' => 'form-control']) !!}
                 </div>
                 <div class="col-sm-3">
                    @php 
                    $cop[-1] = 'Select Co-Payment';
                    @endphp
                    @for($i = 0; $i <= 35; $i=$i+5)
                    @php $cop[$i] = $i; @endphp
                    @endfor 
                        {!! Form::select('copayments[]', $cop, null, ['class' => 'form-control']) !!}
                    </div>
                 <div class="col-sm-2">
                     <a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field"><span class="la la-plus-circle la-2x"></span> </a>
                 </div>
             </div>
            @endif
        @else
             <div class="form-group row"> 
                @php 
                    $prods = App\Product::pluck('name','id')->toArray();
                    $prods[] = ['0' => 'Select Product'];
                @endphp    

                 <div class="col-sm-3">
                     {!! form :: select ('products[]',$prods,0,['id'=>'products-holder', 'class' => 'select2 form-control'])!!}

                 </div>
                 <div class="text-center col-sm-1">
                     <span class="label label-danger">X</span>
                 </div>
                 <div class="col-sm-3">
                     {!! Form::text('quantities[]', null, [  'placeholder'=>'Enter Product\'s quantity', 'class' => 'form-control']) !!}
                 </div>
                 <div class="col-sm-3">
                    @php 
                    $cop[-1] = 'Select Co-Payment';
                    @endphp
                    @for($i = 0; $i <= 35; $i=$i+5)
                    @php $cop[$i] = $i; @endphp
                    @endfor 
                        {!! Form::select('copayments[]', $cop, null, ['class' => 'form-control']) !!}
                    </div>
                 <div class="col-sm-2">
                     <a href="javascript:void(0);" style="padding-top:6px;" class="add_button btn btn-success" title="Add field"><span class="la la-plus-circle la-2x"></span> </a>
                 </div>
             </div>
        @endif
    </div>
</div>

@if(isset($order))
    <div class="form-group row">
        <label for="default-input" class="col-sm-2 form-control-label">
            {!! Form::label('status_id', 'Status:') !!}
        </label>

        <div class="col-sm-10">
            {!! Form::select('status_id', \App\Status::pluck('message','id'), $order->status_id,  [  'class' => 'form-control']) !!}
        </div>

    </div>
@endif

<!-- Submit Field -->
<div class="form-group row" id='submit'>
    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('orders.index') !!} " class="btn btn-default"> Cancel</a>
</div>

@push('customjs')
<script src="{{ asset('libs/src/jquery.tokeninput.js') }}"></script>
<script type="text/javascript">
    $('.fancybox').fancybox();
</script>
<?php
$data = (request()->route()->getAction()['as'] == "orders.edit")? DB::table('patients')->select(DB::raw("id, CONCAT(first_name, ' ' , last_name) AS name"))->where('id',$order['patient_id'])->first () : [];
//dd($data->name);
if($data){
    $data = '[{id: '.$data->id.', name: "'.$data->name.'"}] ';//json_encode($data)
}else{
    $data ='';
}
?>
<script type="text/javascript">
    var isEdit = <?= (request()->route()->getAction()['as'] == "orders.edit")? 1 : 0;?>;
    var isAdmin = "<?=  Auth::user()->isAdmin()?>";
    var isCallCenter = "<?=  Auth::user()->isCallCenter()?>";
    var partnerID = "<?= (!Auth::user()->isAdmin() && !Auth::user()->isCallCenter())? Auth::user()->partner_id:'' ?>";
    var partner = (isAdmin != 1 && isCallCenter != 1)? partnerID : $('#partner_id').val();
    var searchableUrl = '{{url("patient/searchpatient")}}?c='+partner;
    $(document).ready(function () {
        $('#products-holder').select2();
        $("#partner_id").on('change', function () {
            partner = $('#partner_id').val();
            searchableUrl = '{{url("patient/searchpatient")}}?c='+partner;
          $('.token-input-list').remove();


            $("#search").tokenInput(searchableUrl,
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'searchDelay':1,
                    'minChars':2,
                    'tokenLimit':1,
                }
            );

            $('#patients-holder ul').addClass('form-control');
            $('#patients-holder ul li').addClass('form-control');
            $('#patients-holder ul').css('width', 'unset');

//            $('#patients-holder ul li.token-input-input-token' ).css('padding', '0px 15px !important');
//            $('#patients-holder ul li.token-input-input-token' ).css('height', '0px !important');
        });
        if(isEdit){
            var isData = <?= (empty($data))? 0 : $data?>;
            var DATA = (isData!=0)? isData : "";
            $("#search").tokenInput(searchableUrl,
                {
                    'prePopulate': DATA,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'searchDelay':1,
                    'minChars':2,
                    'tokenLimit':1,
                }
            );
        }else{
            $("#search").tokenInput(searchableUrl,
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'searchDelay':1,
                    'minChars':2,
                    'tokenLimit':1,
                }
            );
        }
        $('#patients-holder ul').addClass('form-control');
        $('#patients-holder ul li').addClass('form-control');
        $('#patients-holder ul').css('width', 'unset');


    });
</script>

@endpush







