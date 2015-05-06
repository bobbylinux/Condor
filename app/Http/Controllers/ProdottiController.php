<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Response as Response;
use App\Http\Controllers\Controller as BaseController;
use App\Models\Categoria as Categoria;
use App\Models\Prodotto as Prodotto;
use App\Models\Immagine as Immagine;
use App\Models\CategoriaProdotto as CategoriaProdotto;

class ProdottiController extends BaseController {

    protected $prodotto;
    protected $immagine;
    protected $categoria;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Prodotto $prodotto, Immagine $immagine, Categoria $categoria) {
        $this->prodotto = $prodotto;
        $this->immagine = $immagine;
        $this->categoria = $categoria;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Prodotto $prodotto, Immagine $immagine, Categoria $categoria) {
        $this->prodotto = $prodotto;
        $this->immagine = $immagine;
        $this->categoria = $categoria;
    }

    public function getImageInstance(Immagine $immagine) {
        return new $immagine;
    }

    public function getCategoryInstance(Categoria $categoria) {
        return new $categoria;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /* recupero tutti i prodotti dalla classe modello */
        $data['prodotti_lista'] = $this->prodotto->where('cancellato', '=', 'false')->orderBy('titolo', 'asc')->paginate(10);
        /* creo la vista per la visualizzazione della lista di categorie */
        return view('prodotti.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categoria = $this->getCategoryInstance($this->categoria);
        $data['categorie_lista'] = $categoria->where('cancellato', '=', 'false')->orderBy('nome', 'asc')->lists('nome', 'id');
        return view('prodotti.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = array(
            'codice' => Input::get('codice_prodotto'),
            'titolo' => Input::get('titolo_prodotto'),
            'descrizione' => Input::get('descrizione_prodotto'),
            'quantita' => Input::get('quantita_prodotto'),
            'spedizione' => Input::get('spedizione_prodotto'),
            'categoria' => Input::get('categoria_prodotto'),
        );

        if ($this->prodotto->validate($data)) {
            /* validazione immagini */
            $cartella_random = str_random(15);
            $url_file = 'uploads/' . $cartella_random;

            if (Input::hasFile('files')) {
                foreach (Input::file('files') as $file) {
                    $nome_file = $file->getClientOriginalName();
                    $tipo_file = $file->guessClientExtension();
                    $data_img = array(
                        'nome' => $nome_file,
                        'url' => $url_file,
                        'tipo' => $tipo_file,
                        'file' => $file);
                    if (!$this->immagine->validate($data_img)) {
                        $errors = $this->immagine->getErrors();
                        return Redirect::action('ProdottiController@create')->withInput()->withErrors($errors);
                    }
                }
            }
            /* se ho validato le immagini procedo alla memorizzazione di prodotto e immagine */
            $this->prodotto->store($data);
            /* memorizzo immagini */
            if (Input::hasFile('files')) {
                //var_dump(Input::file('files'));
                $prodotto_id = $this->prodotto->id;
                foreach (Input::file('files') as $file) {
                    $nome_file = $file->getClientOriginalName();
                    $tipo_file = $file->guessClientExtension();
                    $data_img = array(
                        'nome' => $nome_file,
                        'url' => $url_file,
                        'tipo' => $tipo_file);

                    $immagine = $this->getImageInstance($this->immagine); //questo è un utilizzo casareccio della Dependency Injection, almeno come io l'ho concepita.... 
                    $immagine->store($data_img, $file);
                    $id = $immagine->id;
                    $this->prodotto->immagini()->attach($id);
                }
            }
            return Redirect::action('ProdottiController@index');
        } else {
            $errors = $this->prodotto->getErrors();
            return Redirect::action('ProdottiController@create')->withInput()->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $data['prodotto'] = $this->prodotto->with('immagini')->find($id);
        $data['categorie'] = CategoriaProdotto::where('prodotto', '=', $id)->get();
        $categoria = $this->getCategoryInstance($this->categoria);

        $data['categorie_lista'] = $categoria->where('cancellato', '=', 'false')->orderBy('nome', 'asc')->lists('nome', 'id');
        return view('prodotti.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = array(
            'codice' => Input::get('codice_prodotto'),
            'titolo' => Input::get('titolo_prodotto'),
            'descrizione' => Input::get('descrizione_prodotto'),
            'quantita' => Input::get('quantita_prodotto'),
            'spedizione' => Input::get('spedizione_prodotto'),
            'categoria' => Input::get('categoria_prodotto')
        );

        $prodotto = $this->prodotto->find($id);
        if ($prodotto->validate($data)) {
            $result = $prodotto->refresh($data);

            return Redirect::action('ProdottiController@index');
        } else {
            $errors = $prodotto->getErrors();
            return Redirect::action('ProdottiController@edit', [$id])->withInput()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $prodotto = $this->prodotto->find($id);
        $result = $prodotto->trash();
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

    /**
     * Search a product by code
     *
     * 
     * @return result
     */
    public function searchByCode($id, $type) {

        $term = Input::get('term');
        $result = $this->prodotto->searchByCode($term, $type);
        return $result;
    }

    /**
     * Search a product by title
     *
     * 
     * @return Result
     */
    public function searchByTitle($id, $type) {
        $term = Input::get('term');
        $result = $this->prodotto->searchByTitle($term, $type);
        return $result;
    }

    /**
     * Detatch image from product
     *
     * 
     * @return null
     */
    public function detachImage($idProduct, $idImage) {
        $this->prodotto->find($idProduct)->immagini()->detach($idImage);
        $result = $this->immagine->find($idImage)->trash();
        if ($result) {
            return Response::json(array(
                    'code' => '200', //OK
                    'msg' => 'OK'));
        } else {
            return Response::json(array(
                    'code' => '500', //OK
                    'msg' => 'KO'));
        }
    }

}
