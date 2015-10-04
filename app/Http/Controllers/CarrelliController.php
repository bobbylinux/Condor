<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Input as Input; 
use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Response as Response;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Prodotto as Prodotto;
use App\Models\Categoria as Categoria;
use App\Models\Valuta as Valuta;
use App\Models\Carrello as Carrello;
use App\Models\ListinoDetail as ListinoDetail;

class CarrelliController extends BaseController
{
    protected $carrello;
    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Carrello $carrello)
    {
        $this->carrello = $carrello;
    }
    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Carrello $carrello)
    {
        $this->carrello = $carrello;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $utente_id = Session::get('utente_id');
        $categoria = new Categoria;
        $carrello = new Carrello;
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        $data['categoria_lista'] = $categoria->where('cancellato', '=', 'false')->orderBy('nome')->get();
        $data['carrello_lista'] = $carrello->showCarrello($utente_id);
        return view('carrello.index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\View\View
     */
    public function store()
    {
        $data = array(
            'utente' => Session::get('utente_id'),
            'prodotto' => Input::get('prodotto_id'),
            'quantita' => Input::get('quantita')
        );

        if ($this->carrello->validate($data)) {
            //ricerco la quantita di elementi nel carrello per questo prodotto
            $quantita = $this->carrello->where('utente', '=', $data['utente'])->where('prodotto', '=', $data['prodotto'])->where('cancellato', '=', false)->count();
            if ($quantita > 0) {
                $carrello = $this->carrello->where('utente', '=', $data['utente'])->where('prodotto', '=', $data['prodotto'])->first();
                $quantita = $carrello->quantita;
                $data['quantita'] = ++$quantita;
                $result = $carrello->store($data);
            } else {
                $carrello = new $this->carrello;
                $result = $carrello->store($data);
            }
            if ($result) {
                return view('carrello.added');
            }
        } else {
            $errors = $this->carrello->getErrors();
            return Redirect::action('CarrelliController@index')->withInput()->withErrors($errors);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function show()
    {
        return true;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $data = array(
            'quantita' => Input::get("quantita"),
        );
        if ($this->carrello->validateUpdate($data)) {
            $carrello = $this->carrello->find($id);
            $quantita_carrello = $carrello->quantita;
            $id_listino = $carrello->prodotto;
            $listino = new ListinoDetail();
            $id_prodotto = $listino->find($id_listino)->prodotto;
            $prodotto = new Prodotto();
            $quantita = $prodotto->find($id_prodotto)->quantita;
            if ($quantita > 0 && $quantita < $data['quantita']) {
                return Response::json(array(
                            'code' => '500', //K0
                            'msg' => 'Questo prodotto ha soltato' . $quantita . ' pezzi disponibili',
                            'quantita' => $quantita_carrello));
            }
            $carrello->refresh($data);            
            $carrello->refreshCartItemsNumber();
            return Response::json(array(
                        'code' => '200', //OK
                        'msg' => 'OK'));
        } else {
            /* recuper la quantità originale e lo rispedisco al mittente */
            $quantita = $this->carrello->find($id)->quantita;
            $errors = $this->carrello->getErrors();
            $msg = $errors->first("quantita");
            return Response::json(array(
                        'code' => '500', //KO
                        'msg' => $msg,
                        'quantita' => $quantita));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $carrello = $this->carrello->find($id);
        $result = $carrello->trash();
        if ($result) {
            $carrello->refreshCartItemsNumber();
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
