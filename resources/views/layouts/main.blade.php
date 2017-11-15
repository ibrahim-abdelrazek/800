<body>
@guest
    @yield('login')
@else
    <body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-position-fixed ks-page-header-fixed ks-theme-primary ks-page-loading">
    @include('layouts.header')
    <div class="ks-page-container">
        @include('layouts.sidebar')
    <div class="ks-column ks-page">
       <!--All Pages should have these structure -->
        <!--<div class="ks-page-header">
            <section class="ks-title">
                <h3>Blank Page</h3>
            </section>
        </div>
        <div class="ks-page-content">
            <div class="ks-page-content-body">
                <div class="container-fluid">
                    Blank page content.
                </div>
            </div>
        </div>-->
        @yield('content')
    </div>
</div>
@endguest