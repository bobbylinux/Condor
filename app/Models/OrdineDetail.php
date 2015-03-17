<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\DB as DB;

class OrdineDetail extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ordini_detail';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('ordine', 'prodotto', 'prezzo');

    /**
     * The variable for system date time
     * 
     */
    protected $now = null;

    /**
     * The variable for validation rules
     * 
     */
    private $rules = array(
        'ordine' => 'required|integer',
        'prodotto' => 'required|integer',
        'prezzo' => 'required|numeric|min:0'
    );

    /**
     * The variable for validation rules
     * 
     */
    private $errors = "";

    /**
     * The function for validate 
     *
     * @data array
     */
    public function validate($data) {
        $validation = Validator::make($data, $this->rules, $this->messages);

        if ($validation->fails()) {
            // set errors and return false
            $this->errors = $validation->errors();
            return false;
        }

        return true;
    }

    /**
     * The function that incapsulate the error variable
     * 
     * @errors array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Function that store detail into database 
     * 
     * @param type $data
     * @return type
     */
    public function store($data) {
        $this->ordine = $data['ordine'];
        $this->prodotto = $data['prodotto'];
        $this->prezzo = $data['prezzo'];
        $this->sconto = $data['sconto'];
        $this->quantita = $data['quantita'];
        $result = self::save();
        return $result;
    }

    /**
     * The function for delete in database from view
     *
     * @data array
     */
    public function trash() {
        $this->now = date('Y-m-d H:i:s');
        $this->cancellato = true;
        $this->data_cancellazione = $this->now;
        $result = $this->save();
        return $result;
    }

    public function getOrdersDetailForUser($userid) {
        $result = DB::table('ordini_master')
                ->join('ordini_detail', 'ordini_master.id', '=', 'ordini_detail.ordine')
                ->join('destinatari', 'ordini_master.destinatario', '=', 'destinatari.id')
                ->join('listini_detail', 'listini_detail.id', '=', 'ordini_detail.prodotto')
                ->join('prodotti', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->join('immagini', 'immagini.prodotto', '=', 'prodotti.id')
                ->where('ordini_master.utente', '=', $userid)
                ->orderby('codice_ordine', 'desc')
                ->select('ordini_master.data_creazione as data_ordine', 'ordini_master.totale as totale_ordine', 'destinatari.nome as destinatario_nome', 'destinatari.cognome as destinatario_cognome', 'ordini_master.codice_ordine as codice_ordine', 'prodotti.titolo as titolo_prodotto', 'immagini.url as immagine_url', 'immagini.nome as immagine_nome')
                ->get();
        return $result;
    }

    public function getOrdersDetailFromMaster($orderid) {
        $result = DB::table('ordini_master')
                ->join('ordini_detail', 'ordini_master.id', '=', 'ordini_detail.ordine')
                ->join('destinatari', 'ordini_master.destinatario', '=', 'destinatari.id')
                ->join('listini_detail', 'listini_detail.id', '=', 'ordini_detail.prodotto')
                ->join('prodotti', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->join('immagini', 'immagini.prodotto', '=', 'prodotti.id')
                ->where('ordini_master.id', '=', $orderid)
                ->orderby('codice_ordine', 'desc')
                ->select('ordini_master.data_creazione as data_ordine', 'ordini_master.totale as totale_ordine', 'destinatari.nome as destinatario_nome', 'destinatari.cognome as destinatario_cognome', 'ordini_master.codice_ordine as codice_ordine', 'prodotti.titolo as titolo_prodotto', 'immagini.url as immagine_url', 'immagini.nome as immagine_nome')
                ->get();
        return $result;
    }

}
