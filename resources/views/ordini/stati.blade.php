@extends('template.blank')
@section('content')
{!!Form::open(array('url' => '/ordini/'.$id_ordine.'/update/stato/', 'method' => 'post','id'=>'form-stati'))!!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">{!!Lang::choice('messages.titolo_aggiorna_ordine',0)!!}</h4>
</div>
<div id="aggiorna-ordine-body" class="modal-body">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                {!! Form::label('nuovo_stato', Lang::choice('messages.nuovo_stato',0)) !!} 
                {!! Form::select('nuovo_stato', $stati_aggiornabili,null,array('id'=>'nuovo-stato','class'=>'form-control')) !!} 
            </div>        
        </div>
    </div>
    <div class="row div-tracking">
        <div class="col-xs-12">
            {!! Form::label('codice_tracking', Lang::choice('messages.codice_tracking',0)) !!}
            {!! Form::text('codice_tracking', '', array('class'=>'form-control','id'=>'tracking-stato')) !!} 
        </div>
    </div>
    <div class="row div-note-stato">
        <div class="col-xs-12">
            {!! Form::label('note_stato', Lang::choice('messages.note_stato',0)) !!}
            {!! Form::textarea('note_stato', '', array('class'=>'form-control','id'=>'note-stato')) !!} 
        </div>
    </div>
    @foreach($lista_stati as $stato)
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-success" role="alert">{!!strtoupper ($stato->stato)!!} {!!Lang::choice('messages.il',0)!!} {!!date("d/m/Y H:i",strtotime($stato->data_stato)) !!} </div>
        </div>
    </div>
    @endforeach
</div>
<div class="modal-footer">
    {!! Form::submit(Lang::choice('messages.pulsante_conferma',0), array('data-token'=>csrf_token(),'class' =>'btn btn-success','id'=>'btn-salva-aggiorna'))!!}                      
    <button type="button" id="btn-chiudi-aggiorna" class="btn btn-primary">{!!Lang::choice('messages.pulsante_chiudi',0)!!}</button>                          
</div>
{!!Form::close()!!}
@stop
