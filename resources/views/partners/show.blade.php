@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables-net/media/css/dataTables.bootstrap4.min.css') }}"> <!-- original -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/libs/datatables-net/datatables.min.css') }}"> <!-- customization -->
<link rel="stylesheet" type="text/css" href="{{ asset('libs/swiper/css/swiper.min.css') }}"> <!-- original -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/widgets/tables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/profile/customer.min.css') }}">
@section('content')
        <div class="ks-page-header">
            <section class="ks-title">
                <h3>{{$partner->name}}</h3>
                <a href="{{ route('partners.index') }}" class="pull-right btn btn-info"><span>Return to Partners</span> </a>
            </section>
        </div>

        <div class="ks-page-content">
            <div class="ks-page-content-body ks-profile">
                <div class="ks-header">
                    <div class="ks-user">
                        <img src="{{ asset($partner->logo) }}" class="ks-avatar" width="100" height="100">
                        <div class="ks-info">
                            <div class="ks-name">{{$partner->name}}</div>
                            <div class="ks-description">{{$partner->location}}</div>
                        </div>
                    </div>
                    <div class="ks-statistics">
                        <div class="ks-item">
                            <div class="ks-amount">{{ App\Order::where('partner_id', $partner->id)->count() }}</div>
                            <div class="ks-text">orders</div>
                        </div>
                        <div class="ks-item">
                            <div class="ks-amount">{{$partner->getTransactionAmount()}}AED</div>
                            <div class="ks-text">Total Orders Revenue</div>
                        </div>
                        <div class="ks-item">
                            <div class="ks-amount">{{ ($partner->getTransactionAmount() * $partner->commisson) /  100}}AED</div>
                            <div class="ks-text">Total Commission</div>
                        </div>
                    </div>
                </div>
                <div class="ks-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                    <ul class="nav ks-nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-toggle="tab" data-target="#overview" aria-expanded="true">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#users" aria-expanded="false">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#doctors" aria-expanded="false">Doctors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#nurses" aria-expanded="false">Nurses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#patients" aria-expanded="false">Patients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#orders" aria-expanded="false">orders</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="false">
                            <div class="ks-overview-tab">
                                <div class="row">
                                    <div class="col-xl-9 ks-tables-container">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <h5 class="card-header">
                                                <span class="ks-text">Last Orders</span>
                                            </h5>
                                            <div class="card-block ks-datatable">
                                                <table id="ks-sales-datatable" class="table table-bordered" style="width:100%" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Order ID#</th>
                                                        <th>Patient</th>
                                                        <th>Doctor</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                    $orders = App\Order::where('partner_id', $partner->id)->OrderBy('id', 'DESC')->take('5')->get()
                                                    @endphp
                                                    @foreach($orders as $order)
                                                    <tr>
                                                        <td>
                                                            <a href="#">{{$order->id}}</a>
                                                        </td>
                                                        <td>{{ $order->patient->first_name . " " . $order->patient->last_name  }}</td>
                                                        <td>
                                                            {{ $order->doctor->name }}
                                                        </td>
                                                        <td>
                                                            <span class="badge ks-circle badge-{{$order->status->code}}">{{$order->status->message}}</span>
                                                        </td>
                                                    </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <h5 class="card-header">
                                                <span class="ks-text">Contact Info</span>
                                            </h5>
                                            <div class="card-block">
                                                <table class="ks-table-description">
                                                    <tr>
                                                        <td class="ks-icon">
                                                            <span class="la la-map-marker"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                           {{$partner->location}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ks-icon ks-fs-16">
                                                            <span class="la la-phone"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                           {{ $partner->phone }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ks-icon">
                                                            <span class="la la-mobile-phone"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                            {{ $partner->fax  }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ks-icon ks-fs-14">
                                                            <span class="la la-envelope"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                            <a href="#">{{$partner->email}}</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                       </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="users" role="tabpanel" aria-expanded="false">
                            <div class="ks-users-tab">
                                <div class="row">
                                    <div class="col-xl-12 ks-tables-container">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <div class="card-block ks-datatable">
                                                <table id="ks-users-datatable" class="table table-bordered" style="width:100%" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th >Name</th>
                                                        <th >User Name</th>
                                                        <th >Email</th>
                                                        <th >User Group</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $users = App\User::where('partner_id', $partner->id)->OrderBy('id', 'DESC')->get()
                                                    @endphp
                                                    @foreach($users as $user)
                                                        <tr>
                                                            <td>{!! $user->name !!}</td>
                                                            <td>{!! $user->username !!}</td>
                                                            <td>{!! $user->email !!}</td>
                                                            <td>{!! $user->userGroup->group_name !!}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="doctors" role="tabpanel" aria-expanded="true">
                            <div class="ks-doctors-tab">
                                <div class="row">
                                    <div class="col-xl-12 ks-tables-container">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <div class="card-block ks-datatable">
                                                <table id="ks-doctors-datatable" class="table table-bordered" style="width:100%" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th rowspan="2">#</th>
                                                        <th rowspan="2">Personal Photo</th>
                                                        <th rowspan="2">Name</th>
                                                        <th rowspan="2">Speciality</th>
                                                        <th colspan="2">Contact Details</th>
                                                    </tr>
                                                    <tr>
                                                        <th> Email</th>
                                                        <th> Number</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $doctors = App\Doctor::where('partner_id', $partner->id)->OrderBy('id', 'DESC')->get()
                                                    @endphp
                                                    @foreach($doctors as $doctor)
                                                        <tr>
                                                            <td scope="row">{{ $doctor->id }}</td>
                                                            <td>
                                                                @if(!empty($doctor->photo))
                                                                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="{{ asset($doctor->photo) }}">
                                                                @else
                                                                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                                                                @endif
                                                            </td>
                                                            <td>{{ $doctor->name }}</td>
                                                            <td>{{ $doctor->specialty }}</td>
                                                            <td>{{$doctor->contact_email}}</td>
                                                            <td>{{ $doctor->contact_number }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="nurses" role="tabpanel" aria-expanded="false">
                            <div class="ks-nurses-tab">
                                <div class="row">
                                    <div class="col-xl-12 ks-tables-container">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <div class="card-block ks-datatable">
                                                <table id="ks-nurses-datatable" class="table table-bordered" style="width:100%" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th rowspan="2">#</th>
                                                        <th rowspan="2">Personal Photo</th>
                                                        <th rowspan="2">Name</th>
                                                        <th colspan="2">Contact Details</th>
                                                    </tr>
                                                    <tr>
                                                        <th> Email</th>
                                                        <th> Number</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $nurses = App\Nurse::where('partner_id', $partner->id)->OrderBy('id', 'DESC')->get()
                                                    @endphp
                                                    @foreach($nurses as $nurse)
                                                        <tr>
                                                            <td scope="row">{{ $nurse->id }}</td>
                                                            <td>
                                                                @if(!empty($nurse->photo))
                                                                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="{{ asset($nurse->photo) }}">
                                                                @else
                                                                    <img style="width: 50px; height: 50px;" class="media-object img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                                                                @endif
                                                            </td>
                                                            <td>{{ $nurse->name }}</td>
                                                            <td>{{$nurse->contact_email}}</td>
                                                            <td>{{ $nurse->contact_number }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="patients" role="tabpanel" aria-expanded="false">
                            <div class="ks-patients-tab">
                                <div class="row">
                                    <div class="col-xl-12 ks-tables-container">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <div class="card-block ks-datatable">
                                                <table id="ks-patients-datatable" class="table table-bordered" style="width:100%" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Contact No.</th>
                                                        <th>Email</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $patients = App\Patient::where('partner_id', $partner->id)->OrderBy('id', 'DESC')->get()
                                                    @endphp
                                                    @foreach($patients as $patient)
                                                        <tr>
                                                            <td>{{ $patient->first_name . $patient->last_name}}</td>
                                                            <td>{{ $patient->contact_number}}</td>
                                                            <td>{{ $patient->email}}</td>
                                                            <td>{{ $patient->notes }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="orders" role="tabpanel" aria-expanded="true">
                            <div class="ks-orders-tab">
                                <div class="row">
                                    <div class="col-xl-12 ks-tables-container">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <div class="card-block ks-datatable">
                                                <table id="ks-orders-datatable" class="table table-bordered" style="width:100%" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient</th>
                                                        <th>Notes</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $orders = App\Order::where('partner_id', $partner->id)->OrderBy('id', 'DESC')->get()
                                                    @endphp
                                                    @foreach($orders as $order)
                                                        <tr>
                                                            <td>{{$order->id}}</td>
                                                            <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}</td>
                                                            <td>{{ $order->notes }}</td>
                                                            <td>{{ $order->created_at }}</td>
                                                            <td>
                                                                <span class="badge ks-circle badge-{{$order->status->code}}">{{$order->status->message}}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('customjs')
    <script src="{{ asset('libs/datatables-net/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables-net/media/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/swiper/js/swiper.jquery.min.js') }}"></script>
    <script type="application/javascript">
        (function ($) {
            $(document).ready(function() {
                var salesDatatable = $('#ks-sales-datatable').DataTable({
                    dom: 'rtip',
                    pageLength: 4
                });
                $('#ks-sales-datatable').DataTable();
                $('#ks-users-datatable').DataTable();
                $('#ks-doctors-datatable').DataTable();
                $('#ks-nurses-datatable').DataTable();
                $('#ks-patients-datatable').DataTable();
                $('#ks-orders-datatable').DataTable();
                var swiper = new Swiper ('.swiper-container', {
                    paginationClickable: true,
                    slidesPerView: 5,
                    spaceBetween: 20,
                    pagination: '.swiper-pagination',
                    autoResize: true,
                    breakpoints: {
                        1024: {
                            slidesPerView: 5,
                            spaceBetween: 40
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 10
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
