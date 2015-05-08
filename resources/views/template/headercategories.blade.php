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

