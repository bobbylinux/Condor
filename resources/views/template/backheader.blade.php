<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                
            </button>
            <a class="navbar-brand" href="/">{!!env('TITLE', 'Condor')!!}</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <?php
                    $language = Session::get('lang', 'it');
                    ?>
                    <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="flag-img" src="{!!url('img/flags/' . $language . '.png')!!}"></a>
                    <ul class="dropdown-menu" role="menu" id="ul-notify">
                        <li><a href="{!!url('/language/en')!!}"><img class="flag-img" src="{!!url('img/flags/en.png')!!}">English</a></li>
                        <li><a href="{!!url('/language/es')!!}"><img class="flag-img" src="{!!url('img/flags/es.png')!!}">Español</a></li>
                        <li><a href="{!!url('/language/it')!!}"><img class="flag-img" src="{!!url('img/flags/it.png')!!}">Italiano</a></li>
                        
                    </ul>-->
                </li>
            </ul> 
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!!Lang::choice('messages.amministra',0)!!}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="dropdown-toggle" href="{!!url('/categorie/')!!}">{!!Lang::choice('messages.categorie',0)!!}</a></li>
                        <li><a href="{!!url('/prodotti/')!!}">{!!Lang::choice('messages.prodotti',0)!!}</a></li>
                        <li><a href="{!!url('/listini/')!!}">{!!Lang::choice('messages.listini_prezzo',0)!!}</a></li>
                        <li><a href="{!!url('/pagamenti/')!!}">{!!Lang::choice('messages.metodi_pagamento',0)!!}</a></li>
                        <li><a href="{!!url('/spedizioni/')!!}">{!!Lang::choice('messages.metodi_spedizione',0)!!}</a></li>                        
                        <li class="divider"></li>
                        <li><a href="{!!url('/ordini/')!!}">{!!Lang::choice('messages.ordini',0)!!}</a></li>
                        @if (Auth::user()->ruolo == 3)
                        <li><a href="{!!url('/valute/')!!}">{!!Lang::choice('messages.valute',0)!!}</a></li>
                        <li class="divider"></li>
                        <li><a href="{!!url('/utenti/')!!}">{!!Lang::choice('messages.utenti',0)!!}</a></li>
                        <li class="divider"></li>
                        <li><a href="{!!url('/configurazione/')!!}">{!!Lang::choice('messages.defauts',0)!!}</a></li>                            
                        @endif
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-bell"></span></a>
                    <ul class="dropdown-menu" role="menu" id="ul-notify">

                    </ul>

                </li>
                @if(Auth::user()->ruolo == 2 || Auth::user()->ruolo == 3) 
                <li>
                    <a href="{!! URL::to('dashboard')!!}"><span class="glyphicon glyphicon-home"></span> {!!Lang::choice('messages.dashboard',0)!!} </a>
                </li>
                @endif
                <li><a href="{!! URL::to('logout') !!}"><span class="glyphicon glyphicon-off"></span> {!!Lang::choice('messages.esci',0)!!}</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>