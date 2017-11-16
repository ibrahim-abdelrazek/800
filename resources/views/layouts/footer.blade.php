<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/responsejs/response.min.js') }}"></script>
<script src="{{ asset('libs/loading-overlay/loadingoverlay.min.js') }}"></script>
<script src="{{ asset('libs/tether/js/tether.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/jscrollpane/jquery.jscrollpane.min.js') }}"></script>
<script src="{{ asset('libs/jscrollpane/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('libs/flexibility/flexibility.js') }}"></script>
<script src="{{ asset('libs/noty/noty.min.js') }}"></script>
<script src="{{ asset('libs/velocity/velocity.min.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/scripts/common.min.js') }}"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="{{ asset('js/app.js') }}"></script>

<div class="ks-mobile-overlay"></div>
@stack('customjs')
</body>
</html>