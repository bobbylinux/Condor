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
            <div class="col-xs-3">
                <a href="/catalogo/prodotto/{!!$prodotto->id!!}"><img src="{!!url($prodotto->url_img .'/'. $prodotto->nome_img)!!}" class="img-thumbnail"/></a>
                <div class="caption">
                    <h4>
                        {!!$prodotto->titolo!!}
                    </h4>
                    <h5 class="prezzo">
                        {!!number_format((float)$prodotto->prezzo, 2, '.', '')!!} {!!$valuta->simbolo!!}
                    </h5>
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