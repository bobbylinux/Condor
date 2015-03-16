@section('content')
{!!Form::open(array('url'=>'spedizioni/'.$spedizione->id,'method'=>'PUT'))!!} 
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('nome_spedizione', Lang::choice('messages.nome_spedizione',0)) !!}
            {!! Form::text('nome_spedizione', $spedizione->spedizione, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('spedizione') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('note_spedizione', Lang::choice('messages.note_spedizione',0)) !!}
            {!! Form::textarea('note_spedizione', $spedizione->note, array('class'=>'form-control')) !!} 
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
    <div class="col-sm-2 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('prezzo_spedizione', Lang::choice('messages.prezzo_spedizione',0)) !!}
            {!! Form::text('prezzo_spedizione', $spedizione->prezzo, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('prezzo') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.modifica_spedizione',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@foreach($errors->all() as $error)
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <p class="bg-danger">{!! $error !!}</p>
    </div>
</div>
@endforeach
@stop