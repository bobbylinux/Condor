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
        $result = DB::select(DB::raw("SELECT ordini_master.data_creazione as data_ordine,ordini_master.totale as totale_ordine,destinatari.nome as destinatario_nome,destinatari.cognome as destinatario_cognome,ordini_master.codice_ordine as codice_ordine,prodotti.titolo as titolo_prodotto,immagini.url as immagine_url,immagini.nome as immagine_nome
                                        FROM ordini_master
                                        JOIN ordini_detail 
                                        ON ordini_master.id = ordini_detail.ordine
                                        JOIN destinatari 
                                        ON ordini_master.destinatario = destinatari.id
                                        JOIN listini_detail 
                                        ON listini_detail.id = ordini_detail.prodotto
                                        JOIN prodotti
                                        ON listini_detail.prodotto = prodotti.id
                                        JOIN (select min(immagini.id) as id,min(url) as url,min(nome) as nome,immagini_prodotti.prodotto as prodotto from immagini join immagini_prodotti on immagini.id = immagini_prodotti.immagine where immagini.cancellato = false group by prodotto) immagini
                                        ON immagini.prodotto = prodotti.id
                                        WHERE ordini_master.utente = :utente
                                        "), array('utente' => $userid));
        return $result;
    }
    
    public function getOrdersDetailDeletedForUser($userid) {
         $result = DB::select(DB::raw("SELECT ordini_master.data_creazione as data_ordine,ordini_master.totale as totale_ordine,destinatari.nome as destinatario_nome,destinatari.cognome as destinatario_cognome,ordini_master.codice_ordine as codice_ordine,prodotti.titolo as titolo_prodotto,immagini.url as immagine_url,immagini.nome as immagine_nome
                                        FROM ordini_master
                                        JOIN ordini_detail 
                                        ON ordini_master.id = ordini_detail.ordine
                                        JOIN destinatari 
                                        ON ordini_master.destinatario = destinatari.id
                                        JOIN listini_detail 
                                        ON listini_detail.id = ordini_detail.prodotto
                                        JOIN prodotti
                                        ON listini_detail.prodotto = prodotti.id
                                        JOIN (select min(immagini.id) as id,min(url) as url,min(nome) as nome,immagini_prodotti.prodotto as prodotto from immagini join immagini_prodotti on immagini.id = immagini_prodotti.immagine where immagini.cancellato = false group by prodotto) immagini
                                        ON immagini.prodotto = prodotti.id
                                        WHERE ordini_master.utente = :utente
                                        AND   ordini_master.cancellato = true
                                        "), array('utente' => $userid));
        return $result;
    }
    public function getOrdersDetailFromMaster($orderid) {
        $result = DB::select(DB::raw("select ordini_master.data_creazione as data_ordine,ordini_master.totale as totale_ordine,destinatari.nome as destinatario_nome,destinatari.cognome as destinatario_cognome,ordini_master.codice_ordine as codice_ordine,prodotti.titolo as titolo_prodotto,immagini.url as immagine_url,immagini.nome as immagine_nome 
                                        FROM ordini_master
                                        JOIN ordini_detail 
                                        ON ordini_master.id = ordini_detail.ordine
                                        JOIN destinatari 
                                        ON ordini_master.destinatario = destinatari.id
                                        JOIN listini_detail 
                                        ON listini_detail.id = ordini_detail.prodotto
                                        JOIN prodotti
                                        ON listini_detail.prodotto = prodotti.id
                                        JOIN (select min(immagini.id) as id,min(url) as url,min(nome) as nome,immagini_prodotti.prodotto as prodotto from immagini join immagini_prodotti on immagini.id = immagini_prodotti.immagine where immagini.cancellato = false group by prodotto) immagini
                                        ON immagini.prodotto = prodotti.id
                                        where ordini_master.id = :ordine
                                    "), array('ordine' => $orderid));
        return $result;
    }

}
