@section('content')
{!!Form::open(array('url'=>'pagamenti','method'=>'POST'))!!} 
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('nome_pagamento', Lang::choice('messages.nome_pagamento',0)) !!}
            {!! Form::text('nome_pagamento', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('note_pagamento', Lang::choice('messages.note_pagamento',0)) !!}
            {!! Form::textarea('note_pagamento', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.aggiungi_pagamento',0), array('class' =>'btn btn-success'))!!} 
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