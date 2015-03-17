<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\DB as DB;

class OrdineMaster extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ordini_master';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('codice_ordine', 'utente', 'destinatario', 'totale', 'pagamento', 'spedizione');

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
        'codice_ordine' => 'required',
        'utente' => 'required|integer',
        'totale' => 'required|numeric|min:0',
        'pagamento' => 'required|integer',
        'spedizione' => 'required|integer'
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
        $this->utente = $data['utente'];
        $this->totale = $data['totale'];
        $this->destinatario = $data['destinatario'];
        $this->pagamento = $data['pagamento'];
        $this->spedizione = $data['spedizione'];
        $result = self::save();
        $id = $this->id;
        $codice_ordine = sprintf("%010d", $id);
        $this->codice_ordine = $codice_ordine;
        self::save();
        $this->statoOrdine()->attach(1); //this executes the insert-query
        return $codice_ordine;
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

    public function getOrdersListForAdmin() {
        $result = DB::select(DB::raw("select    ordini_master.id as id,
                                                ordini_master.codice_ordine as codice_ordine,
                                                utenti.username as nome_utente,
                                                ordini_master.data_creazione as data_ordine,
                                                ordini_master.totale as totale_ordine,
                                                ordini_master.pagato as pagato,
                                                stati_ordine.stato as stato_ordine,
                                                os1.data_modifica as data_stato_ordine,
                                                ordini_master.codice_tracking  as tracking_ordine
                                        from	ordini_master 
                                        join    destinatari
                                        on	ordini_master.destinatario = destinatari.id
                                        join    utenti
                                        on      utenti.id = ordini_master.utente
                                        join	ordini_stato os1
                                        on	ordini_master.id = os1.ordine
                                        left outer join ordini_stato os2 on ordini_master.id = os2.ordine AND
                                                (os1.data_modifica < os2.data_modifica OR os1.data_modifica = os2.data_modifica AND os1.id < os2.id)
                                        join    stati_ordine
                                        on	os1.stato = stati_ordine.id
                                        where 	os2.id is null
                                        and     ordini_master.cancellato = false
                                        order by data_ordine desc
                                        "));

        return $result;
    }

    /**
     * The function for get all orders of an user
     *
     * @data array
     */
    public function getOrdersListForUser($userid) {
        $result = DB::select(DB::raw("select    ordini_master.data_creazione as data_ordine,
                                                ordini_master.totale as totale_ordine,
                                                destinatari.nome as destinatario_nome,
                                                destinatari.cognome as destinatario_cognome,
                                                ordini_master.codice_ordine as codice_ordine,
                                                stati_ordine.stato as stato_ordine,
                                                os1.data_modifica as data_stato_ordine 
                                        from	ordini_master 
                                        join    destinatari
                                        on	ordini_master.destinatario = destinatari.id
                                        join	ordini_stato os1
                                        on	ordini_master.id = os1.ordine
                                        left outer join ordini_stato os2 on ordini_master.id = os2.ordine AND
                                                (os1.data_modifica < os2.data_modifica OR os1.data_modifica = os2.data_modifica AND os1.id < os2.id)
                                        join    stati_ordine
                                        on	os1.stato = stati_ordine.id
                                        where 	os2.id is null
                                        and     ordini_master.utente = :utente
                                        order by data_ordine desc
                                        "), array('utente' => $userid));

        return $result;
    }
    /**
     * The function for get an order by id
     *
     * @data array
     */
    public function getOrdersListById($orderid) {
        $result = DB::select(DB::raw("select    ordini_master.data_creazione as data_ordine,
                                                ordini_master.totale as totale_ordine,
                                                destinatari.nome as destinatario_nome,
                                                destinatari.cognome as destinatario_cognome,
                                                ordini_master.codice_ordine as codice_ordine,
                                                stati_ordine.stato as stato_ordine,
                                                os1.data_modifica as data_stato_ordine 
                                        from	ordini_master 
                                        join    destinatari
                                        on	ordini_master.destinatario = destinatari.id
                                        join	ordini_stato os1
                                        on	ordini_master.id = os1.ordine
                                        left outer join ordini_stato os2 on ordini_master.id = os2.ordine AND
                                                (os1.data_modifica < os2.data_modifica OR os1.data_modifica = os2.data_modifica AND os1.id < os2.id)
                                        join    stati_ordine
                                        on	os1.stato = stati_ordine.id
                                        where 	os2.id is null
                                        and     ordini_master.id = :orderid
                                        order by data_ordine desc
                                        "), array('orderid' => $orderid));

        return $result;
    }
    
    public function getOrderStatus($orderid) {
        $result = DB::table('stati_ordine')
                ->join('ordini_stato', 'ordini_stato.stato', '=', 'stati_ordine.id')
                ->where('ordini_stato.ordine', '=', $orderid)
                ->orderby('ordini_stato.data_creazione','desc')
                ->select('stati_ordine.stato as stato','ordini_stato.data_creazione as data_stato','ordini_stato.note as note')
                ->get();
        return $result;
    }
    
    public function statoOrdine() {
        return $this->belongsToMany('StatoOrdine','ordini_stato','ordine','stato')->withPivot('note');;
    }
    
    public function getPagato() {
        return $this->pagato;
    }
    
    public function setPagato($pagato) {
        $this->pagato = $pagato;
        $this->data_pagamento = date('Y-m-d H:i:s');
        $result = $this->save();
        return $result;
    }
    
    public function setStato($data) {   
        if ($data['stato']=="3") {
            $this->codice_tracking = $data['tracking'];
            $this->save();
        }
        $result = $this->statoOrdine()->attach($data['stato'],array("note" => $data['note'])); //this executes the insert-query
        return $result; 
    }
   
    /*funzione che genera il codice temporaneo per l'ordine finalizzato all'univocità del pagamento*/
    public function createTempCode() {
        $codeTemp = DB::select(DB::raw("SELECT nextval('codice_ordine_temp_seq') AS codetemp"));
        return $codeTemp[0]->codetemp;
    }
}
