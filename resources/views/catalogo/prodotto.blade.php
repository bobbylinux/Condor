@section('navbar_categorie')
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categoria <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        @foreach($categoria_lista as $categoria)
        <li><a href="{!!url('/catalogo/categoria/' . $categoria->id)!!}">{!!$categoria->nome!!}</a></li>
        @endforeach
    </ul>
</li>
@stop
@section('content')
{!!Form::open(array('url'=>'carrello','method'=>'POST'))!!} 
<div class="row">
    <div class="col-xs-12">
        <ol class="breadcrumb">
            <li class="active">{!!$prodotto->titolo!!}
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        <img src="{!!url($prodotto->url_img .'/'. $prodotto->nome_img)!!}" class="img-thumbnail" />
    </div>
    <div class="col-xs-8">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">      
                    <h3>
                        {!!$prodotto->titolo!!}
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">   
            <div class="col-xs-12">
                <div class="form-group">      
                    <h4>
                        {!!Lang::choice('messages.prezzo',0)!!}: {!!number_format((float)$prodotto->prezzo, 2, '.', '')!!} {!!$valuta->simbolo !!}
                    </h4>
                </div>
            </div>
        </div>
        <?php
        $qta = $prodotto->quantita;
        if ($qta < 1) {
            $qta = 30;
        } 
        ?>
        <div class="row">
            <div class="col-xs-3 col-sm-2">
                <div class="form-group">            
                    {!! Form::label('quantita', Lang::choice('messages.quantita',0)) !!}  
                    {!! Form::selectRange('quantita', 1, $qta) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">       
                    {!! Form::submit(Lang::choice('messages.aggiungi_al_carrello',0), array('class' =>'btn btn-success'))!!} 
                    {!! Form::hidden('prodotto_id', $prodotto->id_prodotto)!!} 
                </div>
            </div>
        </div>    
    </div>
</div>
</div>

{!!Form::close()!!} 
@stop