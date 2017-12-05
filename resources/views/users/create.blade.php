<div class="row">
    <div class="col-lg-12 ks-panels-column-section">
        <div class="card">
            <div class="card-block">
                <h5 class="card-title">Create new User</h5>

                {!! Form::open(['route' => 'users.store', 'files' => true]) !!}

                @include('users.fields')

                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
@push('customjs')
@if(Auth::user()->isAdmin())
    <script type="application/javascript">
        // asynchronous content
        (function ($) {
            $(document).ready(function () {
//                loadUserGroup($('select[name=partner_id]').val());
//                $('select[name=partner_id]').on('change', function(e){
//                    var partner_id = $(this).val();
//                    loadUserGroup(partner_id);
//                });
            });
            {{--function loadUserGroup(partner_id)--}}
            {{--{--}}
                {{--$.getJSON("{{url('/users/get-userGroups')}}/" + partner_id, [], function (data) {--}}
                    {{--var html = '';--}}
                    {{--if(data.success){--}}
                        {{--html = '<select class="form-control ks-select" name="user_group_id">';--}}
                        {{--$.each(data.data , function (key, value) {--}}
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

