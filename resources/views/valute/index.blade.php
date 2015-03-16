@section('content')
<div class="row">
    <div class="col-xs-12">
        <a href="{!!url('/valute/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuova_valuta',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-12">
        {!! $valute_lista->links() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{!!Lang::choice('messages.titolo_index_valuta_nome',0)!!}</th>
                    <th>{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                </tr>
            <thead>
                @foreach($valute_lista as $valuta)
                <tr> 
                    <td>{!!$valuta['nome']!!}</td>
                    <td>
                        <a href="{!!url('/valute/'.$valuta['id'].'/edit')!!}" class="btn btn-primary">{!! Lang::choice('messages.pulsante_modifica',0)!!}</a>
                        <a href="{!!url('/valute/'.$valuta['id'])!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!! Lang::choice('messages.pulsante_elimina',0)!!}</a>

                    </td>
                </tr> 
                @endforeach
        </table>
    </div>
</div>
@stop