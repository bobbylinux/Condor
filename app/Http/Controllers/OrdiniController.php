<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Response as Response;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Auth as Auth;

use App\Models\OrdineMaster as OrdineMaster;
use App\Models\OrdineDetail as OrdineDetail;
use App\Models\Valuta as Valuta;
use App\Models\Carrello as Carrello;
use App\Models\Spedizione as Spedizione;
use App\Models\Destinatario as Destinatario;
use App\Models\Pagamento as Pagamento;
use App\Models\ListinoDetail as ListinoDetail;
use App\Models\StatoOrdine as StatoOrdine;

class OrdiniController extends BaseController {

    public $layout = 'template.front';
    protected $ordine_master;
    protected $ordine_detail;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(OrdineMaster $ordine_master, OrdineDetail $ordine_detail) {
        $this->ordine_master = $ordine_master;
        $this->ordine_detail = $ordine_detail;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(OrdineMaster $ordine_master, OrdineDetail $ordine_detail) {
        $this->ordine_master = $ordine_master;
        $this->ordine_detail = $ordine_detail;
    }

    public function getDetailIstance(OrdineDetail $ordine_detail) {
        return new $ordine_detail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $ordine = new OrdineMaster();
        $valuta = new Valuta();
        $data['valuta'] = $valuta->getValuta();
        $data['ordini_lista'] = $ordine->getOrdersListForAdmin();
        return view('ordini.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //reperisco i dati del carrello
        $user = Auth::user()->id;
        $carrello = new Carrello;
        $lista_prodotti = $carrello->where('utente', '=', $user)->where('cancellato', '=', false)->get();
        $totale = 0;

        foreach ($lista_prodotti as $prodotto) {
            $prodotto_id = $prodotto->prodotto;
            $listino = ListinoDetail::find($prodotto_id);
            $prezzo = $listino->prezzo;
            $sconto = $listino->sconto;
            $sconto = 1 - ($sconto / 100);
            $prezzo *= $sconto;
            $totale += $prezzo;
        }

        $spedizione = Input::get("spedizione");
        $destinatario = Input::get("destinatario");
        $pagamento = Input::get("pagamento");

        if ($spedizione == "" || $spedizione == null) {
            $costo_spedizione = 0;
            $spedizione = null;
        } else {
            $costo_spedizione = Spedizione::find($spedizione)->prezzo;
        }
        $totale +=$costo_spedizione;

        $data_master = array(
            'utente' => Auth::user()->id,
            'destinatario' => $destinatario,
            'totale' => $totale,
            'pagamento' => $pagamento,
            'spedizione' => $spedizione
        );

        $id_ordine = $this->ordine_master->store($data_master);

        foreach ($lista_prodotti as $prodotto) {
            $codice_listino = $prodotto->prodotto;
            $listino = ListinoDetail::find($codice_listino);
            $prezzo_listino = $listino->prezzo;
            $sconto_listino = $listino->sconto;
            $quantita = $prodotto->quantita;
            $data_detail = array(
                'ordine' => $id_ordine,
                'prodotto' => $codice_listino,
                'prezzo' => $prezzo_listino,
                'sconto' => $sconto,
                'quantita' => $quantita
            );
            $ordini_detail = $this->getDetailIstance($this->ordine_detail);
            $result = $ordini_detail->store($data_detail);
        }
        //una volta chiuso l'ordine devo cancellare brutalmente i record per non intasare il db.
        $lista_prodotti = $carrello->where('utente', '=', $user)->get();
        foreach ($lista_prodotti as $prodotto) {
            $prodotto->brutal_trash();
        }

        $carrello->refreshCartItemsNumber();
        $data['cmd'] = "_xclick";
        $data['amount'] = Input::get("amount");
        $data['lc'] = Session::get('lang','it');
        $data['currency_code'] = Input::get("currency_code");
        $data['item_name'] = "Ordine " . env('TITLE','e-commerce') ;
        $data['item_number'] = $id_ordine;
        $data['shipping'] = Input::get("prezzo-spedizione");
        $data['handling'] = 0;
        $data['business'] = env("PAYPAL_SELLER","roberto.bani-seller@gmail.com");
        $data['cancel_return'] = url(); 
        $data['buyer_email'] = Auth::user()->username;
        
        return view('ordini.payment', $data);
    }
    
    /*funzione che genera il codice temporaneo per l'ordine finalizzato all'univocità del pagamento*/
    public function getTempCode() {
        $tmpcode = $this->ordine_master->createTempCode();
        $code = sprintf('%017d', $tmpcode);
        $code = "TMP" . $code;
        return Response::json(array(
                    'code' => $code, //OK
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $ordine_detail = $this->ordine_detail->where('ordine', '=', $id)->get();
        $error = false;

        foreach ($ordine_detail as $detail) {
            if (!$detail->trash()) {
                $error = true;
            }
        }
        if (!$error) {
            $result = true;
        }

        $ordine_master = $this->ordine_master->find($id);
        $result = $ordine_master->trash();

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

    public function chooseAddress() {
        $destinatario = new Destinatario;
        $data['indirizzi_lista'] = $destinatario->where('utente', '=', Auth::user()->id)->where('cancellato', '=', false)->get();
        $this->layout->content = View::make('destinatari.index', $data);
    }

    public function newAddress() {
        return view('destinatari.create');
    }

    public function storeAddress() {
        $destinatario = new Destinatario;
        $cognome = Input::get('cognome');
        $nome = Input::get('nome');
        $note = Input::get('note');
        $indirizzo = Input::get('indirizzo');
        $citta = Input::get('citta');
        $cap = Input::get('cap');
        $provincia = Input::get('provincia');
        $paese = Input::get('paese');
        $recapito = Input::get('recapito');

        $data = array('cognome' => $cognome,
            'nome' => $nome,
            'note' => $note,
            'indirizzo' => $indirizzo,
            'citta' => $citta,
            'cap' => $cap,
            'provincia' => $provincia,
            'paese' => $paese,
            'recapito' => $recapito);

        if ($destinatario->validate($data)) {
            $destinatario->store($data);
            return Redirect::action('OrdiniController@orderConfirm');
        } else {
            $errors = $destinatario->getErrors();
            return Redirect::action('OrdiniController@newAddress')->withInput()->withErrors($errors);
        }
    }

    public function chooseTravel() {
        $spedizione = new Spedizione;
        $data['spedizione_lista'] = $spedizione->where('cancellato', '=', false)->get();
        $this->layout->content = View::make('ordini.spedizione', $data);
    }

    public function orderConfirm() {
        $destinatario = new Destinatario;
        $spedizione = new Spedizione;
        $pagamento = new Pagamento;
        $valuta = new Valuta;
        $carrello = new Carrello;
        $data['totale_carrello'] = $carrello->getCartPrice(Auth::user()->id);
        $data['valuta'] = $valuta->getValuta();
        $data['indirizzi_lista'] = $destinatario->where('utente', '=', Auth::user()->id)->where('cancellato', '=', false)->get();
        $data['spedizione_lista'] = $spedizione->where('cancellato', '=', false)->get();
        $data['pagamento_lista'] = $pagamento->where('cancellato', '=', false)->get();
        return view('ordini.confirm', $data);
    }

    public function userOrders() {
        $data['lista_ordini'] = $this->ordine_master->getOrdersListForUser(Auth::user()->id);
        $data['lista_ordini_attivi'] = $this->ordine_master->getOrdersActivedForUser(Auth::user()->id);
        $data['lista_ordini_cancellati'] = $this->ordine_master->getOrdersDeletedForUser(Auth::user()->id);
        $data['dettaglio_ordini'] = $this->ordine_detail->getOrdersDetailForUser(Auth::user()->id);
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        return view('ordini.userlist', $data);
    }

    public function detail($orderid) {
        $data['lista_ordini'] = $this->ordine_master->getOrdersListById($orderid);
        $data['dettaglio_ordini'] = $this->ordine_detail->getOrdersDetailFromMaster($orderid);
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        return view('ordini.detail', $data);
    }

    public function aggiorna($orderid) {
        $data['id_ordine'] = $orderid;
        $data['lista_stati'] = $this->ordine_master->getOrderStatus($orderid);
        $stati_ordine = new StatoOrdine();
        $data['stati_aggiornabili'] = $stati_ordine->where('cancellato', '=', false)->lists('stato', 'id');
        return view('ordini.stati', $data);
    }
    
    /*set stato */
    public function setStato($orderid) {
        $ordine = $this->ordine_master->find($orderid);
        $data = array(
            'stato' => Input::get("stato"),
            'note' => Input::get("note"),
            'tracking' => Input::get("tracking")
        );
        
        $ordine->setStato($data);
        return Response::json(array(
                    'code' => '200', //OK
                    'msg' => 'OK'));
    }
    /* funzione marca pagato */

    public function pagato($orderid) {
        $ordine = $this->ordine_master->find($orderid);
        $pagato = $ordine->getPagato();
        if ($pagato) {
            $ordine->setPagato(false);
        } else {
            $ordine->setPagato(true);
        }

        return Response::json(array(
                    'code' => '200', //OK
                    'msg' => 'OK'));
    }

}
