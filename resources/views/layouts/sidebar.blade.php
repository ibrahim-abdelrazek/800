<!-- BEGIN DEFAULT SIDEBAR -->
<div class="ks-column ks-sidebar ks-info">
    <div class="ks-wrapper ks-sidebar-wrapper">
        <ul class="nav nav-pills nav-stacked">
            <li class="nav-item ks-user dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="<?= (empty(Auth::user()->avatar))? asset('upload/avatars/default.jpg') : asset('upload/avatars/'.Auth::user()->avatar);?>" width="36" height="36" class="ks-avatar rounded-circle">
                    <div class="ks-info">
                        <div class="ks-name">{{ Auth::user()->name }}</div>
                        <div class="ks-text">{{ Auth::user()->usergroup->group_name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                    <a class="dropdown-item" href="{{ url('/') }}">Settings</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="ks-icon la la-dashboard"></span>
                    <span>Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->isAdmin())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('partnertypes.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-flask"></span>
                    <span>Partner Types</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('partners.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-cubes"></span>
                    <span>Partner</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->isAdmin() || Auth::user()->isPartner())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('usergroups.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-toggle-off"></span>
                    <span>User Groups</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-user"></span>
                    <span>Users</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('hotelguest.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-sliders"></span>
                    <span>Hotel Guests</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctors.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-credit-card"></span>
                    <span>Doctors</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('nurses.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-puzzle-piece"></span>
                    <span>Nurses</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('patients.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-th"></span>
                    <span>Patients</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-file-text-o"></span>
                    <span>Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders.index') }}" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <span class="ks-icon la la-usd"></span>
                    <span>Orders</span>
                </a>
            </li>
        </ul>
        <div class="ks-sidebar-extras-block">
            <div class="ks-sidebar-copyright">© {{ date('Y') }} 800Pharmacy. All right reserved</div>
        </div>
    </div>
</div>
<!-- END DEFAULT SIDEBAR -->
