<!DOCTYPE html>
<html>
    <head>
        <title>{!!env('TITLE', 'Condor')!!}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{!! url('js/jquery-ui-1.10.4/themes/base/jquery.ui.all.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('bs/css/bootstrap.min.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('metro-bs/css/metro-bootstrap.min.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('js/vbox/venobox.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('css/custom.css') !!}" rel="stylesheet" media="screen">	
        <link href="{!! url('css/jquery.cookiebar.css') !!}" rel="stylesheet" media="screen">	
    </head>
    <body style="background-color: <?php echo env('BG_COLOR', '#ffffff')?>">        
        <div class="container-fluid">
            <div class="row">   
                    @include('template.frontheader')
            </div>
            <div class="row">
                    @yield('content')
            </div>

            <div id="wait-msg" class="col-sm-12" style="display:none;"> 
                <h3>{!!Lang::choice('messages.attendere',0)!!}</h3> 
            </div> 
        </div>
        <script src="{!! url('http://code.jquery.com/jquery.js') !!}"></script>
        <script src="{!! url('js/jquery.cookiebar.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.core.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.widget.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.dialog.js') !!}"></script>	
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.datepicker.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/i18n/jquery.ui.datepicker-it.js') !!}"></script>
        <script src="{!! url('js/blockui.js') !!}"></script>
        <script src="{!! url('js/scripts.js') !!}"></script>
        <script src="{!! url('bs/js/bootstrap.min.js') !!}"></script> 
        <script src="{!! url('js/vbox/venobox.min.js') !!}"></script>
    </body>
</html>