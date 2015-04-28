<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Categoria as Categoria;

class CategorieController extends BaseController {

    //public $layout = 'template.back';
    protected $categoria;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Categoria $categoria) {
        $this->categoria = $categoria;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Categoria $categoria) {
        $this->categoria = $categoria;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /* recupero tutte le categoria dalla classe modello */
        $data['categorie_lista'] = $this->categoria->where('cancellato', '=', 'false')->orderBy('nome', 'asc')->paginate(10);
        /* creo la vista per la visualizzazione della lista di categorie */
        return view('categorie.index',$data);//$this->layout->content = View::make('categorie.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $data['categorie_padre'] = $this->categoria->where('cancellato', '=', 'false')->orderBy('nome', 'asc')->lists('nome', 'id');
        return view('categorie.create',$data);//$this->layout->content = View::make('categorie.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = array(
            'nome' => \Input::get('nome_categoria'),
            'descrizione' => \Input::get('descrizione_categoria'),
            'padre' => \Input::get('padre_categoria')
        );
        if ($this->categoria->validate($data)) {
            $result = $this->categoria->store($data);
            return \Redirect::action('CategorieController@index');
        } else {
            $errors = $this->categoria->getErrors();
            return \Redirect::action('CategorieController@create')->withInput()->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $data['categorie_padre'] = $this->categoria->orderBy('nome', 'asc')->get()->lists('nome', 'id');
        $data['categoria'] = $this->categoria->find($id);
        return view('categorie.edit',$data);//$this->layout->content = View::make('categorie.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = array(
            'nome' => \Input::get('nome_categoria'),
            'descrizione' => \Input::get('descrizione_categoria'),
            'padre' => \Input::get('padre_categoria')
        );

        $categoria = $this->categoria->find($id);
        if ($this->categoria->validate($data)) {
            $categoria->refresh($data);
            return \Redirect::action('CategorieController@index');
        } else {
            $errors = $this->categoria->getErrors();
            return \Redirect::action('CategorieController@edit', [$id])->withInput()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $categoria = $this->categoria->find($id);
        $result = $categoria->trash();
        if ($result) {
            return Response::json(array(
                        'code' => '200', //OK
                        'msg' => 'OK'));
        } else {
            return Response::json(array(
                        'code' => '500', //KO
                        'msg' => 'KO'));
        }
    }


}
