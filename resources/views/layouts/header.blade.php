<!-- BEGIN HEADER -->
<nav class="navbar ks-navbar">
    <!-- BEGIN HEADER INNER -->
    <!-- BEGIN LOGO -->
    <div href="{{ url('/') }}" class="navbar-brand">
        <!-- BEGIN RESPONSIVE SIDEBAR TOGGLER -->
        <a href="#" class="ks-sidebar-toggle"><i class="ks-icon la la-bars" aria-hidden="true"></i></a>
        <a href="#" class="ks-sidebar-mobile-toggle"><i class="ks-icon la la-bars" aria-hidden="true"></i></a>
        <!-- END RESPONSIVE SIDEBAR TOGGLER -->

        <div class="ks-navbar-logo">
            <a href="{{ url('/') }}" class="ks-logo">{{$AppName }}</a>
        </div>
    </div>
    <!-- END LOGO -->

    <!-- BEGIN MENUS -->
    <div class="ks-wrapper">
        <nav class="nav navbar-nav">
            <!-- BEGIN NAVBAR MENU -->
            <div class="ks-navbar-menu">

            </div>
            <!-- END NAVBAR MENU -->

            <!-- BEGIN NAVBAR ACTIONS -->
            <div class="ks-navbar-actions">

                <!-- BEGIN NAVBAR MESSAGES -->
                <div class="nav-item dropdown ks-messages">
                    <a class="nav-link dropdown-toggle" href="{{route('messages')}}" >
                        <!-- data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false" -->
                        <span id="messenger-notifier" class="la la-envelope ks-icon" aria-hidden="true">
                            {{--<span class="badge badge-pill badge-info">3</span>--}}
                        </span>
                        <span class="ks-text">Messages</span>
                    </a>
                    {{--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">--}}
                        {{--<section class="ks-tabs-actions">--}}
                            {{--<a href="#"><i class="la la-plus ks-icon"></i></a>--}}
                            {{--<a href="#"><i class="la la-search ks-icon"></i></a>--}}
                        {{--</section>--}}
                        {{--<ul class="nav nav-tabs ks-nav-tabs ks-info" role="tablist">--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link active" href="#" data-toggle="tab"--}}
                                   {{--data-target="#ks-navbar-messages-inbox" role="tab">Inbox</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        {{--<div class="tab-content">--}}
                            {{--<div class="tab-pane ks-messages-tab active" id="ks-navbar-messages-inbox" role="tabpanel">--}}
                                {{--<div id="messagesMenu" class="ks-wrapper ks-scrollable">--}}

                                {{--</div>--}}
                                {{--<div class="ks-view-all">--}}
                                    {{--<a href="{{route('messages')}}">View all</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <!-- END NAVBAR MESSAGES -->

                <!-- BEGIN NAVBAR NOTIFICATIONS -->
                <div class="nav-item dropdown ks-notifications">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        <span id="notifier" class="la la-bell ks-icon" aria-hidden="true">
                        </span>
                        <span class="ks-text">Notifications</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                        <ul class="nav nav-tabs ks-nav-tabs ks-info" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-toggle="tab"
                                   data-target="#navbar-notifications-all" role="tab">All</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane ks-notifications-tab active" id="navbar-notifications-all"
                                 role="tabpanel">
                                <div id="notificationsMenu" class="ks-wrapper" style="overflow: scroll !important;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END NAVBAR NOTIFICATIONS -->

                <!-- BEGIN NAVBAR USER -->
                <div class="nav-item dropdown ks-user">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        <span class="ks-avatar">
                            <img src="<?= (empty(Auth::user()->avatar))? asset('upload/avatars/default.jpg') : asset('upload/avatars/'.Auth::user()->avatar);?>" width="36" height="36">
                        </span>
                        <span class="ks-info">
                            <span class="ks-name">{{ Auth::user()->name }}</span>
                            <span class="ks-description">{{ Auth::user()->usergroup->group_name }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <span class="la la-user ks-icon"></span>
                            <span>Profile</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/settings') }}">
                            <span class="la la-wrench ks-icon" aria-hidden="true"></span>
                            <span>Settings</span>
                        </a>
                        <form method="POST" action="{{route('logout')}}">
                            {{csrf_field()}}
                            <button style="cursor:pointer;" type="submit" class="dropdown-item">
                                <span class="la la-sign-out ks-icon" aria-hidden="true"></span>
                                <span>Logout</span>
                            </button>
                        </form>

                    </div>
                </div>
                <!-- END NAVBAR USER -->
            </div>
            <!-- END NAVBAR ACTIONS -->
        </nav>

        <!-- BEGIN NAVBAR ACTIONS TOGGLER -->
        <nav class="nav navbar-nav ks-navbar-actions-toggle">
            <a class="nav-item nav-link" href="#">
                <span class="la la-ellipsis-h ks-icon ks-open"></span>
                <span class="la la-close ks-icon ks-close"></span>
            </a>
        </nav>
        <!-- END NAVBAR ACTIONS TOGGLER -->

        <!-- BEGIN NAVBAR MENU TOGGLER -->
        <nav class="nav navbar-nav ks-navbar-menu-toggle">
            <a class="nav-item nav-link" href="#">
                <span class="la la-th ks-icon ks-open"></span>
                <span class="la la-close ks-icon ks-close"></span>
            </a>
        </nav>
        <!-- END NAVBAR MENU TOGGLER -->
    </div>
    <!-- END MENUS -->
    <!-- END HEADER INNER -->
</nav>
<!-- END HEADER -->

