<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Response as Response;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Pagamento as Pagamento;

class PagamentiController extends BaseController {
    
    protected $pagamento;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Pagamento $pagamento) {
        $this->pagamento = $pagamento;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Pagamento $pagamento) {
        $this->pagamento = $pagamento;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /* recupero tutte le categoria dalla classe modello */
        $data['pagamenti_lista'] = $this->pagamento->where('cancellato', '=', 'false')->orderBy('pagamento', 'asc')->paginate(10);
        /* creo la vista per la visualizzazione della lista di categorie */
        return view('pagamenti.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('pagamenti.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = array(
            'pagamento' => Input::get('nome_pagamento'),
            'note' => Input::get('note_pagamento')
        );
        if ($this->pagamento->validate($data)) {
            $result = $this->pagamento->store($data);
            return Redirect::action('PagamentiController@index');
        } else {
            $errors = $this->pagamento->getErrors();
            return Redirect::action('PagamentiController@create')->withInput()->withErrors($errors);
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
        $data['pagamento'] = $this->pagamento->find($id);
        return view('pagamenti.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = array(
            'pagamento' => Input::get('nome_pagamento'),
            'note' => Input::get('note_pagamento')
        );

        $pagamento = $this->pagamento->find($id);
        if ($this->pagamento->validate($data)) {
            $pagamento->refresh($data);
            return Redirect::action('PagamentiController@index');
        } else {
            $errors = $this->pagamento->getErrors();
            return Redirect::action('PagamentiController@edit', [$id])->withInput()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $pagamento = $this->pagamento->find($id);
        $result = $pagamento->trash();
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
