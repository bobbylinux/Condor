@extends('template.front')
@section('content')
<?php
$id = "";
$idx = 1;
?>
@foreach($prodotti_lista as $prodotto)
@if ($id != $prodotto->id)
@if ($idx%7==0 || $idx==1)
<div class="row">
@endif
    <div class="item active">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="thumbnail">        
                <a href="/catalogo/prodotto/{!!$prodotto->id!!}"><img src="{!!url($prodotto->url_img .'/'. $prodotto->nome_img)!!}" class="fixed-width img-thumbnail"/></a>    
                    <p> 
                        <strong>{!!$prodotto->titolo!!}</strong>          
                    </p>
                    <p class="prezzo">
                        {!!number_format((float)$prodotto->prezzo, 2, '.', '')!!} {!!$valuta->simbolo!!}
                    </p>
            </div>
        </div>                                
    </div>
@if ($idx%6==0 || $idx==6)
</div>
@endif
<?php
$id = $prodotto->id;
$idx++;
?>
@endif
@endforeach
@stop