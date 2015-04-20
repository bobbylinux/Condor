<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\DB as DB;

class Prodotto extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prodotti';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('codice', 'titolo', 'descrizione', 'spedizione');

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
        'codice' => 'required|min:2|max:32',
        'titolo' => 'required|max:128',
        'descrizione' => 'max:1400000',
        'quantita' => 'integer',
        'spedizione' => 'required|boolean'
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
     * The function for store in database from view
     *
     * @data array
     */
    public function store($data) {
        $this->codice = $data['codice'];
        $this->titolo = $data['titolo'];
        $this->descrizione = $data['descrizione'];
        if ($data['quantita'] != "") {
            $this->quantita = $data['quantita'];
        }
        $this->spedizione = $data['spedizione'];
        self::save();
        $last_id = $this->id;
        //una volta memorizzato il prodotto devo andare a popolare la tabella pivot sulle categorie
        $catProd = new CategoriaProdotto;
        $catProd->prodotto = $last_id;
        $catProd->categoria = $data['categoria'];
        $catProd->save();
    }

    /**
     * The function for update in database from view
     *
     * @data array
     */
    public function refresh($data) {
        $this->codice = $data['codice'];
        $this->titolo = $data['titolo'];
        $this->descrizione = $data['descrizione'];
        if ($data['quantita'] != "") {
            $this->quantita = $data['quantita'];
        } else {
            $this->quantita = null;
        }
        $this->spedizione = $data['spedizione'];
        $this->save();
        /* deve essere gestita la categoria del prodotto appena capito come far arrivare il tutto qua */
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

    /**
     * The function retrieves all product with a specific code
     *
     * @data array
     */
    public function searchByCode($code, $type) {
        switch ($type) {
            case 'like':
                $arg = array(strtolower("%" . $code . "%"));
                $result = DB::table('prodotti')->whereRaw('lower(codice) like ? and cancellato = false order by codice', $arg)->get();
                break;
            case 'equal':
                $arg = array(strtolower($code));
                $result = DB::table('prodotti')->whereRaw('lower(codice) = ? and cancellato = false order by codice', $arg)->get();
                break;
        }
        return $result;
    }

    /**
     * The function retrieves all product with a specific code
     *
     * @data array
     */
    public function searchByTitle($title, $type) {
        switch ($type) {
            case 'like':
                $arg = array(strtolower("%" . $title . "%"));
                $result = DB::table('prodotti')->whereRaw('lower(titolo) like ? and cancellato = false order by titolo', $arg)->get();
                break;
            case 'equal':
                $arg = array(strtolower($title));
                $result = DB::table('prodotti')->whereRaw('lower(titolo) = ? and cancellato = false order by titolo', $arg)->get();
                break;
        }
        return $result;
    }

    /**
     * The function for one to many relationship 
     *
     * @var string
     */
    public function immagine() {
        return $this->hasMany('Immagine', 'prodotto');
    }

    /**
     * The function for many to many relationship 
     *
     * @var string
     */
    function categorie() {
        return $this->belongsToMany('Categoria', 'categorie_prodotti', 'prodotto', 'categoria');
    }

    /**
     * The function for many to many relationship 
     *
     * @var string
     */
    function listini() {
        return $this->belongsToMany('ListinoMaster', 'listini_detail', 'prodotto', 'listino')->withPivot("prezzo", "sconto");
    }

    public function showCategory($id) {
        $result = DB::table('prodotti')
                ->join('categorie_prodotti', 'categorie_prodotti.prodotto', '=', 'prodotti.id')
                ->join('listini_detail', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                ->join('immagini', 'immagini.prodotto', '=', 'prodotti.id')
                ->where('prodotti.cancellato', '=', false)
                ->where('categorie_prodotti.cancellato', '=', false)
                ->where('listini_detail.cancellato', '=', false)
                ->where('listini_master.cancellato', '=', false)
                ->where('immagini.cancellato', '=', false)
                ->where('categorie_prodotti.categoria', '=', $id)
                ->select('listini_detail.id as id', 'prodotti.titolo', 'listini_detail.prezzo as prezzo', 'immagini.url as url_img', 'immagini.nome as nome_img')
                ->get();
        return $result;
    }

    public function showActives() {
        $result = DB::select(DB::raw("select  ld.id as id, pr.titolo, ld.prezzo as prezzo, im.url as url_img, im.nome as nome_img
                                        from prodotti pr
                                        join categorie_prodotti cp on cp.prodotto = pr.id
                                        join listini_detail ld on ld.prodotto = pr.id
                                        join listini_master lm on lm.id = ld.listino
                                        join (select min(id) as id,min(url) as url,min(nome) as nome,immagini.prodotto as prodotto from immagini where immagini.cancellato = false group by prodotto) im on im.prodotto = pr.id
                                        where pr.cancellato = false
                                        and   cp.cancellato = false
                                        and   ld.cancellato = false
                                        and   lm.cancellato = false
                                        and   (current_timestamp) between lm.data_inizio and lm.data_fine 
                                    "));
        return $result;
    }

}
