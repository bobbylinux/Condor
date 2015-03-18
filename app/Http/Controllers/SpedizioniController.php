<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Response as Response;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Spedizione as Spedizione;

class SpedizioniController extends BaseController {

    public $layout = 'template.back';
    protected $spedizione;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Spedizione $spedizione) {
        $this->spedizione = $spedizione;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Spedizione $spedizione) {
        $this->spedizione = $spedizione;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /* recupero tutti i prodotti dalla classe modello */
        $data['spedizioni_lista'] = $this->spedizione->where('cancellato', '=', 'false')->orderBy('spedizione', 'asc')->paginate(10);
        /* creo la vista per la visualizzazione della lista di categorie */
        return view('spedizioni.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('spedizioni.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = array(
            'spedizione' => Input::get('nome_spedizione'),
            'note' => Input::get('note_spedizione'),
            'prezzo' => Input::get('prezzo_spedizione')
        );

        if ($this->spedizione->validate($data)) {
            $this->spedizione->store($data);
            return Redirect::action('SpedizioniController@index');
        } else {
            $errors = $this->spedizione->getErrors();
            return Redirect::action('SpedizioniController@create')->withInput()->withErrors($errors);
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
        $data['spedizione'] = $this->spedizione->find($id);
        return view('spedizioni.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = array(
            'spedizione' => Input::get('nome_spedizione'),
            'note' => Input::get('note_spedizione'),
            'prezzo' => Input::get('prezzo_spedizione')
        );
        
        $spedizione = $this->spedizione->find($id);
        if ($spedizione->validate($data)) {
            $spedizione->refresh($data);
            return Redirect::action('SpedizioniController@index');
        } else {
            $errors = $spedizione->getErrors();
            return Redirect::action('SpedizioniController@edit')->withInput()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $spedizione = $this->spedizione->find($id);
        $result = $spedizione->trash();
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
