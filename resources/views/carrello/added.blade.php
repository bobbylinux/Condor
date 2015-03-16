@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                {!!Lang::choice('messages.articolo_aggiunto',0)!!}
            </div>
        </div>     
    </div>
</div>
<div class="row">
    {!!Form::open(array('url'=>'order/confirm','method'=>'POST'))!!} 
    <div class="col-sm-2">        
        <a href="{!!url('/carrello')!!}" class="btn btn-warning">{!!Lang::choice('messages.modifica_carrello',0)!!}</a>        
    </div>
    <div class="col-sm-2">
        {!! Form::submit(Lang::choice('messages.procedi_all_acquisto',0), array('class' =>'btn btn-success'))!!} 
    </div>
    {!!Form::close()!!}
</div>
@stop

