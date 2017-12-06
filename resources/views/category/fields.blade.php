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
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('name', 'Category Name:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        {!! Form::text('name', null, [  'class' => 'form-control']) !!}
    </div>
</div>
<!--  Parent -->
<div class="form-group row">
    <label for="default-input" class="col-sm-2 form-control-label">
        {!! Form::label('parent', 'Parent:',['class'=> 'required']) !!}</label>
    <div class="col-sm-10">
        @php
            $categories = \App\Category::where("parent",0)->get();
        @endphp
        @if(!isset($category))
            <select name="parent" class="form-control">
                <option value="0">root</option>

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
            @php $parent= $category->parent  @endphp
            <select name="parent" class="form-control">

                <option value="0" @if($parent==0)  {{"selected"}} @endif>root</option>

                @foreach($categories as $category)
                    <option value="{{$category->id}}" @if($parent==$category->id)  {{"selected"}} @endif><b>{{ $category->name }}</b> </option>

                    @if(!$category->children->isEmpty())
                        @foreach($category->children as $subcategory)
                            <option value="{{$subcategory->id }}" @if($parent==$subcategory->id)  {{"selected"}} @endif>&nbsp &nbsp &nbsp{{ $subcategory->name }}</option>

                            @if(!$subcategory->children->isEmpty())
                                @foreach($subcategory->children as $subcategory1)
                                    <option value="{{$subcategory1->id }}" @if($parent==$subcategory1->id)  {{"selected"}} @endif>&nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp   &nbsp {{ $subcategory1->name }}</option>>
                                @endforeach

                            @endif

                        @endforeach

                    @endif

                @endforeach

            </select>
        @endif
{{--
        {!! Form::select('parent',  array_add( \App\Category::pluck("name","id"),0,"root"),null, [ 'class' => 'form-control']) !!}
--}}
    </div>
</div>



<!-- Submit Field -->
<div class="form-group col-sm-8 col-sm-offset-2" id='submit'>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}

    @if(!empty($edit))
            <a id="back" class="btn btn-default" href="{{ route('category.index') }}" >back</a>
    @else
            <button id="reset" class="btn btn-default" type="button">Reset</button>
    @endif

</div>







