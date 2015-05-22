<?php
namespace App\Lib\Storage\Categoria;

use App\Models\Categoria as Categoria;
use App\Lib\Storage\Categoria\CategoriaRepository as CategoriaRepository;
use App\Http\Controllers\CategorieController as CategorieController;

class EloquentCategoriaRepository implements CategoriaRepository
{

    private $categoria;

    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    public function index()
    {
        return $this->categoria->where('cancellato', '=', 'false')->orderBy('nome', 'asc')->paginate(10);
        //return Categoria::all();
    }

    public function store()
    {
        $data = array(
            'nome' => \Input::get('nome_categoria'),
            'descrizione' => \Input::get('descrizione_categoria'),
            'padre' => \Input::get('padre_categoria')
        );
        if ($this->categoria->validate($data)) {
            $this->categoria->nome = $data['nome'];
            $this->categoria->descrizione = $data['descrizione'];
            if ($data['padre'] == '') {
                $data['padre'] = null;
            }
            $this->categoria->padre = $data['padre'];
            $this->categoria->save();
            return \Redirect::action('CategorieController@index');
        } else {
            $errors = $this->categoria->getErrors();
            return \Redirect::action('CategorieController@create')->withInput()->withErrors($errors);
        }

    }

    public function show($id)
    {
        return $this->categoria->find($id);
    }

    public function update($id)
    {
        $data = array(
            'nome' => \Input::get('nome_categoria'),
            'descrizione' => \Input::get('descrizione_categoria'),
            'padre' => \Input::get('padre_categoria')
        );
        $categoria = $this->categoria->find($id);
        if ($this->categoria->validate($data)) {
            $categoria->nome = $data['nome'];
            $categoria->descrizione = $data['descrizione'];
            if ($data['padre'] == '') {
                $data['padre'] = null;
            }
            $categoria->padre = $data['padre'];
            $categoria->save();
            return \Redirect::action('CategorieController@index');
        } else {
            $errors = $this->categoria->getErrors();
            return \Redirect::action('CategorieController@edit', [$id])->withInput()->withErrors($errors);
        }
    }

    public function destroy($id)
    {
        $categoria = $this->categoria->find($id);
        $categoria->data_cancellazione =  date('Y-m-d H:i:s');
        $categoria->cancellato = true;
        $categoria->save();
        return true;
    }

    public function getAllActivesList()
    {
        return $this->categoria->where('cancellato', '=', 'false')->orderBy('nome', 'asc')->lists('nome', 'id');
    }
}