@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'pagamenti/'.$pagamento->id,'method'=>'PUT'))!!} 
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('nome_pagamento', Lang::choice('messages.nome_pagamento',0)) !!}
            {!! Form::text('nome_pagamento', $pagamento->pagamento, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('pagamento') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('note_pagamento', Lang::choice('messages.note_pagamento',0)) !!}
            {!! Form::textarea('note_pagamento', $pagamento->note, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>     
@foreach($errors->get('note') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.modifica_pagamento',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop