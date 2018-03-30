@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/jquery-confirm/jquery.confirm.min.css') }}"> <!-- original -->
    <!-- customization -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- original -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/flexdatalist/jquery.flexdatalist.min.css')}}"> <!-- customization -->
@endpush

@section('content')



        <div class="ks-page-content">
            <div class="ks-page-content-body">
                <div class="container-fluid">
                {!! Form::model($category, ['route' => ['category.update', $category->id], 'method' => 'patch', 'files'=>true]) !!}

                @include('category.fields', ['edit' => true])

                {!! Form::close() !!}
                </div>
            </div>
        </div>


@endsection
