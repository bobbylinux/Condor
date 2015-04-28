<html>
    <head>
        <title>Condor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="{!! url('js/jquery-ui-1.10.4/themes/base/jquery.ui.all.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('bs/css/bootstrap.min.css') !!}" rel="stylesheet" media="screen">
        <link href="{!! url('css/custom.css') !!}" rel="stylesheet" media="screen">	
        <script src="{!! url('http://code.jquery.com/jquery.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.core.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.widget.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.dialog.js') !!}"></script>	
        <script src="{!! url('js/jquery-ui-1.10.4/ui/jquery.ui.datepicker.js') !!}"></script>
        <script src="{!! url('js/jquery-ui-1.10.4/ui/i18n/jquery.ui.datepicker-it.js') !!}"></script>
        <script src="{!! url('js/scripts.js') !!}"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->

    </head>
    <body>        
        <div class="content">
            <div class="row">            
                <div class="col-sm-12">
                    <h1>Condor</h1>
                </div>
                <div class="col-sm-12">
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="#">Brand</a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="#">Link</a></li>
                                    <li><a href="#">Link</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Amministra <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{!!url('/categorie/')!!}">Categorie</a></li>
                                            <li><a href="{!!url('/prodotti/')!!}">Prodotti</a></li>
                                            <li><a href="{!!url('/valute/')!!}">Valute</a></li>
                                            <li><a href="{!!url('/listini/')!!}">Listino Prezzi</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">One more separated link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <form class="navbar-form navbar-left" role="search">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Ricerca">
                                    </div>
                                    <button type="submit" class="btn btn-default">Vai</button>
                                </form>
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="#">Link</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            </div>
            <div class="col-sm-3">
                @section('sidebar-left')
                @show
            </div>
            <div class="col-sm-6">
                @yield('content')
            </div>
            <div class="col-sm-3">
                @section('sidebar-right')
                @show                
            </div>
            @section('modal-warning')
            <div class="modal fade" id="msg-warning">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Attenzione</h4>
                        </div>
                        <div class="modal-body">
                            <p>Si &egrave; sicuri di voler cancellare? <br>Questa operazione &egrave; irreversibile</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-annulla">Annulla</button>
                            <button type="button" class="btn btn-danger" id="btn-conferma">Conferma</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            @show
        </div>
        <script src="{!! url('bs/js/bootstrap.min.js') !!}"></script> 
    </body>
</html>