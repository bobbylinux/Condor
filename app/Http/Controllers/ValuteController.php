<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Valuta as Valuta;

use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Response as Response;

class ValuteController extends BaseController {
    
    public $layout = 'template.back';
    
    protected $valuta;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Valuta $valuta) {
        
        //$this->middleware('superuser');
        $this->valuta = $valuta;
        
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Valuta $valuta) {
        $this->valuta = $valuta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /* recupero tutti i prodotti dalla classe modello */
        $data['valute_lista'] = $this->valuta->where('cancellato','=','false')->orderBy('nome','asc')->paginate(10);
        /* creo la vista per la visualizzazione della lista di categorie */
        return view('valute.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('valute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = array(
            'nome' => Input::get('nome_valuta'),
            'simbolo' => Input::get('simbolo_valuta'),
            'sigla' => Input::get('sigla_valuta')
        );

        if ($this->valuta->validate($data)) {
            $result = $this->valuta->store($data);

            return Redirect::action('ValuteController@index');
        } else {
            $errors = $this->valuta->getErrors();
            return Redirect::action('ValuteController@create')->withInput()->withErrors($errors);
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
        $data['valuta'] = $this->valuta->find($id);
        return view('valute.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = array(
            'nome' => Input::get('nome_valuta'),
            'simbolo' => Input::get('simbolo_valuta'),
            'sigla' => Input::get('sigla_valuta')
        );

        $valuta = $this->valuta->find($id);
        if ($valuta->validate($data)) {
            $valuta->refresh($data);

            return Redirect::action('ValuteController@index');
        } else {
            $errors = $valuta->getErrors();
            return Redirect::action('ValuteController@edit', [$id])->withInput()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $valuta = $this->valuta->find($id);
        $result = $valuta->trash();
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
