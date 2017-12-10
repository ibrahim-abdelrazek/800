@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 ks-panels-column-section">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Edit User</h5>


                    {!! Form::model($user, ['route' => ['users.update', $user['id']], 'method' => 'patch', 'files' => true]) !!}

                    @include('users.fields')

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
@endsection
@push('customjs')
    @if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
        <script type="application/javascript">
            // asynchronous content
            (function ($) {
//                $(document).ready(function () {
//                    $('label[for="avatar"]').removeClass('required');
//                    $('label[for="password"]').removeClass('required');
//                    $('label[for="password_confirmation"]').removeClass('required');
//
//
//
//                    loadUserGroup($('select[name=partner_id]').val());
//                    $('select[name=partner_id]').on('change', function(e){
//                        var partner_id = $(this).val();
//                        loadUserGroup(partner_id);
//                    });
//                });
                {{--function loadUserGroup(partner_id)--}}
                {{--{--}}
                    {{--$.getJSON("{{url('/users/get-userGroups')}}/" + partner_id, [], function (data) {--}}
                        {{--var html = '';--}}
                        {{--if(data.success){--}}
                            {{--html = '<select class="form-control ks-select" name="user_group_id">';--}}
                            {{--var ugID = "{{$user->user_group_id}}";--}}
                            {{--$.each(data.data , function (key, value) {--}}
                                {{--if(ugID == key)--}}
                                    {{--html += '<option selected value="'+key+'">'+value+'</option>';--}}
                                {{--else--}}
                                    {{--html += '<option value="'+key+'">'+value+'</option>';--}}
                            {{--});--}}
                            {{--html += '</select>';--}}
                            {{--$('input[type=submit]').prop('disabled', function(i, v) { return false; });--}}
                        {{--}else{--}}
                            {{--html = "<p>You don't have added usergroups yet, Please <a href='{{route("usergroups.index")}}'><b class='label-danger'>Add " +--}}
                                {{--"new UserGroup</b></a></p>";--}}
                            {{--$('input[type=submit]').prop('disabled', function(i, v) { return true; });--}}
                        {{--}--}}
                        {{--$('#usergroups-holder').html(html);--}}

                    {{--})--}}
                {{--}--}}

            })(jQuery);

        </script>
    @endif
@endpush