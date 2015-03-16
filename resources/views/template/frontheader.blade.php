<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">       
            <a class="navbar-brand" href="/">Condor</a>
            <ul class="nav navbar-nav">     
                
            </ul>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            {!!Form::open(array('url'=>'catalogo/search','method'=>'POST','role'=>'search','class'=>'navbar-form navbar-left'))!!} 
            <div class="form-group">
                {!! Form::text('ricerca', '', array('class'=>'form-control','placeholder'=>Lang::choice('messages.ricerca',0))) !!}                     
            </div>
            {!! Form::submit(Lang::choice('messages.vai',0), array('class' =>'btn btn-success'))!!} 
            {!!Form::close()!!}
            <ul class="nav navbar-nav navbar-right">
                @if(!Auth::check())                
                <li><a href="{!! URL::to('login') !!}"><span class="glyphicon glyphicon-play-circle"></span> {!!Lang::choice('messages.accedi',0)!!}</a></li>
                @else
                @if(Auth::user()->ruolo == 2 || Auth::user()->ruolo == 3) 
                <li>
                    <a href="{!! URL::to('dashboard')!!}"><span class="glyphicon glyphicon-home"></span> {!!Lang::choice('messages.dashboard',0)!!} </a>
                </li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {!!Lang::choice('messages.mio_account',0)!!}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{!!url('order/history')!!}">{!!Lang::choice('messages.miei_ordini',0)!!}</a></li>
                        <li class="divider"></li>
                    </ul>
                </li>
                <li><a href="{!! URL::to('logout') !!}"><span class="glyphicon glyphicon-off"></span> {!!Lang::choice('messages.esci',0)!!}</a></li>
                @endif    
                <li>
                    <a href="{!! URL::to('carrello')!!}"><span class="glyphicon glyphicon-shopping-cart"></span> {!!Lang::choice('messages.carrello',0)!!} <span class="badge" id="cart-counter">{!! Session::get('utente_carrello')!!}</span></a>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>