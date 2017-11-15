<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title>800 Pharmacy</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/line-awesome/css/line-awesome.min.css') }}">
    <!--<link rel="stylesheet" type="text/css" href="assets/fonts/open-sans/styles.css">-->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/montserrat/styles.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('libs/tether/css/tether.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/jscrollpane/jquery.jscrollpane.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/common.min.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/widgets/payment.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/kosmo/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/widgets/panels.min.css') }}">
    <!-- END GLOBAL MANDATORY STYLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <!-- BEGIN THEME STYLES -->
    @guest
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/pages/auth.min.css') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/themes/primary.min.css') }}">

    @endguest
    <link class="ks-sidebar-dark-style" rel="stylesheet" type="text/css"
                  href="{{ asset('assets/styles/themes/sidebar-black.min.css') }}">
            <!-- END THEME STYLES -->
            @stack('customcss')
            <script>
                window.Laravel = { csrfToken: '{{ csrf_token() }}' };
            </script>
            @if(!auth()->guest())
                <script>
                    window.Laravel.userId = <?php echo auth()->user()->id; ?>
                </script>
            @endif
        <script>
            //request user permission for notification and messaging
            window.Notification.requestPermission();
        </script>
</head>

<!-- END HEAD -->
