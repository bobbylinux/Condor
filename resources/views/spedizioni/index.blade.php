@section('content')
<div class="row">
    <div class="col-xs-12">
        <a href="{{url('/spedizioni/create')!!}" class="btn btn-success">{{Lang::choice('messages.nuova_metodologia_spedizione',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-12">
        {{ $spedizioni_lista->links() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-responsive">
            <thead>        
                <tr>
                    <th>{{Lang::choice('messages.titolo_index_spedizione_nome',0)!!}</th>
                    <th>{{Lang::choice('messages.titolo_azioni',0)!!}</th>
                </tr>
            </thead>
            @foreach($spedizioni_lista as $spedizione)
            <tr> 
                <td>{{$spedizione['spedizione']!!}</td>
                <td>
                    <a href="{{url('/spedizioni/'.$spedizione['id'].'/edit')!!}" class="btn btn-primary">{{Lang::choice('messages.pulsante_modifica',0)!!}</a>
                    <a href="{{'/spedizioni/'.$spedizione['id']!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{{Lang::choice('messages.pulsante_elimina',0)!!}</a>
                </td>
            </tr> 
            @endforeach      
        </table>
    </div>
</div>
@stop