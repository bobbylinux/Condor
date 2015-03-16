<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;

class ConfigurazioneController extends BaseController {

    public $layout = 'template.back';
    protected $configurazione;
    
    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Configurazione $configurazione) {
        $this->configurazione = $configurazione;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Configurazione $configurazione) {
        $this->configurazione = $configurazione;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /* recupero configurazione dalla classe modello */
        $data['configurazione'] = $this->configurazione->where('cancellato', '=', 'false')->first();
        /* creo la vista per la visualizzazione della lista di categorie */
        $this->layout->content = View::make('configurazione.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
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
        $data['configurazione'] = $this->configurazione->find($id);
        $this->layout->content = View::make('configurazione.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = array(
            'titolo' => Input::get('titolo'),
            'logo' => Input::get('logo'),
            'sfondo' => Input::get('sfondo'),
            'lingua' => Input::get('lingua')
        );

        $configurazione = $this->configurazione->find($id);
        if ($this->configurazione->validate($data)) {
            $configurazione->refresh($data);
            return Redirect::action('DashController@showDashboard');
        } else {
            $errors = $this->categoria->getErrors();
            return Redirect::action('ConfigurazioneController@edit', [$id])->withInput()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
