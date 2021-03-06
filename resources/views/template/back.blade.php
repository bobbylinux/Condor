<!DOCTYPE html>
<html>
    <head>
        <title>{!!env('TITLE', 'Condor')!!}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="{!! url('js/jquery-ui-1.10.4/themes/base/jquery.ui.all.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('bs/css/bootstrap.min.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('metro-bs/css/metro-bootstrap.min.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('js/vbox/venobox.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('css/jquery.cookiebar.css') !!}" rel="stylesheet" media="screen">	
        <link href="{!! url('css/custom.css') !!}" rel="stylesheet" media="screen">	
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css" rel="stylesheet" media="screen">
        <link href="{!! url('css/cropimg.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('css/font-awesome.min.css') !!}" rel="stylesheet" media="screen">
    </head>    
    <body style="background-color: <?php echo env('BG_COLOR', '#ffffff') ?>">    
        <div class="container-fluid">            
            <div class="row">
                @include('template.backheader')
            </div>
            <div class="row">
                @yield('content')
            </div>
            @section('modal-warning')
            <div class="modal fade" id="msg-warning">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">{!!Lang::choice('messages.modale_titolo',0)!!}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!!Lang::choice('messages.modale_testo',0)!!}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-annulla">{!!Lang::choice('messages.pulsante_annulla',0)!!}</button>
                            <button type="button" class="btn btn-danger" id="btn-conferma">{!!Lang::choice('messages.pulsante_conferma',0)!!}</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            @show
            @section('modal-load-img')
                <div class="modal fade" id="msg-load-img">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">{!!Lang::choice('messages.crop_img_title',0)!!}</h4>
                            </div>
                            <div class="modal-body"><img alt="jQuery Image Cropping Plug-In" id="example" src="" /></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-conferma">{!!Lang::choice('messages.pulsante_conferma',0)!!}</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            @show
        </div>
        <div id="wait-msg" class="col-sm-12" style="display:none;"> 
            <h3>{!!Lang::choice('messages.attendere',0)!!}</h3> 
        </div> 
        <script src="{!! url('http://code.jquery.com/jquery.js') !!}"></script>
        <script src="{!! url('js/jquery.cookiebar.js') !!}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/i18n/jquery.ui.datepicker-it.js') !!}"></script>
        <script src="{!! url('bs/js/bootstrap.min.js') !!}"></script>
        <script src="{!! url('js/blockui.js') !!}" ></script>
        <script src="{!! url('js/vbox/venobox.min.js') !!}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
        <script src="{!! url('js/cropimg/jquery.mousewheel.js') !!}"></script>
        <script src="{!! url('js/cropimg/cropimg.jquery.min.js') !!}"></script>
        <script src="{!! url('js/scripts.js') !!}"></script>
    </body>
</html>