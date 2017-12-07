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
@if(!isset($product))
<!--  id -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('id', 'Barcode:',['class'=> 'required']) !!}
    {!! Form::text('id', null, [  'class' => 'form-control']) !!}
</div>
@endif
<!--  title -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('name', 'Title:',['class'=> 'required']) !!}
    {!! Form::text('name', null, [  'class' => 'form-control']) !!}
</div>


<!--  category -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('category', 'Category:') !!}
    @php
        $categories = \App\Category::where("parent",0)->get();
    @endphp
    @if(!isset($product))
        <select name="category[]"  multiple class="form-control" style="height: 200px;">

            @foreach($categories as $category)
                <option value="{{$category->id}}"><b>{{ $category->name }}</b> </option>

                @if(!$category->children->isEmpty())
                    @foreach($category->children as $subcategory)
                        <option value="{{$subcategory->id }}">&nbsp &nbsp &nbsp{{ $subcategory->name }}</option>

                        @if(!$subcategory->children->isEmpty())
                            @foreach($subcategory->children as $subcategory1)
                                <option value="{{$subcategory1->id }}">&nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp   &nbsp {{ $subcategory1->name }}</option>>
                            @endforeach

                        @endif

                    @endforeach

                @endif

            @endforeach

        </select>
    @else
        @php
            $catss = $product->category;
            $cats = array();
            foreach ($catss as $c){
                $cats[] = $c->id;
            }
        @endphp
        <select name="category[]" multiple class="form-control" style="height: 200px;">


            @foreach($categories as $category)
                <option value="{{$category->id}}" @if(in_array($category->id,$cats))  {{"selected"}} @endif><b>{{ $category->name }}</b> </option>

                @if(!$category->children->isEmpty())
                    @foreach($category->children as $subcategory)
                        <option value="{{$subcategory->id }}" @if(in_array($subcategory->id,$cats))  {{"selected"}} @endif>&nbsp &nbsp &nbsp{{ $subcategory->name }}</option>

                        @if(!$subcategory->children->isEmpty())
                            @foreach($subcategory->children as $subcategory1)
                                <option value="{{$subcategory1->id }}" @if(in_array($subcategory1->id,$cats))  {{"selected"}} @endif>&nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp   &nbsp {{ $subcategory1->name }}</option>>
                            @endforeach

                        @endif

                    @endforeach

                @endif

            @endforeach

        </select>
    @endif
</div>



<!--  image -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image',  [  'class' => 'form-control']) !!}
</div>



<!--  price -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price',null, [ 'step'=>"any", 'class' => 'form-control']) !!}
</div>

<!--  quantity -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('qty', 'Quantity:') !!}
    {!! Form::text('qty', null, [  'class' => 'form-control']) !!}
</div>

<!--  description -->
<div class="form-group col-sm-8 col-sm-offset-2" id=''>
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, [  'class' => 'form-control']) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    <a href="{!! route('products.index') !!} " class="btn btn-default" > Cancel</a>
</div>








