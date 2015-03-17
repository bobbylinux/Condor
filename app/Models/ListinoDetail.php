<?php namespace App\Models;

use \Illuminate\Support\Facades\DB as DB;
use \Illuminate\Support\Facades\Validator as Validator;

class ListinoDetail extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'listini_detail';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('listino', 'prodotto', 'prezzo');

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
        'listino' => 'required|integer',
        'prodotto' => 'required|integer',
        'prezzo' => 'required|numeric|min:0',
        'sconto' => 'integer|max:100|min:0'
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
        $this->listino = $data['listino'];
        $this->prodotto = $data['prodotto'];
        $this->prezzo = $data['prezzo'];
        $this->sconto = $data['sconto'];
        if (trim($this->sconto) == "") {
            $this->sconto = 0;
        }
        $result = self::save();

        return $result;
    }
    
    /**
     * Function that update detail into database 
     * 
     * @param type $data
     * @return type
     */
    public function refresh($data) {
        $this->prezzo = $data['prezzo'];
        $this->sconto = $data['sconto'];
        if (trim($this->sconto) == "") {
            $this->sconto = 0;
        }
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

    /**
     * 
     * The function return the object ready for watch detail in detail editing
     *       
     */
    public function getDetailForMaster($id) {
        $result = DB::table('listini_detail')
                ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                ->join('prodotti', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->where('prodotti.cancellato', '=', false)
                ->where('listini_detail.cancellato', '=', false)
                ->where('listini_master.cancellato', '=', false)
                ->where('listini_master.id', '=', $id)
                ->orderby('titolo')
                ->select('prodotti.codice as codice', 'prodotti.titolo as titolo', 'listini_detail.prezzo as prezzo', 'listini_detail.sconto as sconto', 'listini_detail.id as listini_id')
                ->get();

        return $result;
    }

    /**
     * Defines a one-to-many relationship.
     *
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function products() {
        return $this->hasMany('Prodotto', 'id');
    }

    public function searchByTitle($title, $type = 'equal') {
        switch ($type) {
            case "like":
                $arg = array(strtolower("%" . $title . "%"));
                $result = DB::table('prodotti')
                        ->join('listini_detail', 'listini_detail.prodotto', '=', 'prodotti.id')
                        ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                        ->join('immagini', 'immagini.prodotto', '=', 'prodotti.id')
                        ->where('prodotti.cancellato', '=', false)
                        ->where('listini_detail.cancellato', '=', false)
                        ->where('listini_master.cancellato', '=', false)
                        ->where('immagini.cancellato', '=', false)
                        ->whereRaw('lower(prodotti.titolo) like ?', $arg)
//                        ->where('listini_detail.id', '=', $id_detail)
                        ->select('listini_detail.id as id', 'prodotti.titolo', 'listini_detail.prezzo as prezzo', 'immagini.url as url_img', 'immagini.nome as nome_img')
                        ->orderBy('titolo')
                        ->get();
                break;
            case "equal":
                $result = DB::table('prodotti')
                        ->join('listini_detail', 'listini_detail.prodotto', '=', 'prodotti.id')
                        ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                        ->join('immagini', 'immagini.prodotto', '=', 'prodotti.id')
                        ->where('prodotti.cancellato', '=', false)
                        ->where('listini_detail.cancellato', '=', false)
                        ->where('listini_master.cancellato', '=', false)
                        ->where('immagini.cancellato', '=', false)
                        ->where('listini_detail.id', '=', $title)
                        ->select('listini_detail.id as id', 'prodotti.titolo', 'listini_detail.prezzo as prezzo', 'immagini.url as url_img', 'immagini.nome as nome_img')
                        ->get();
                break;
        }
        return $result;
    }

    public function searchById($id_detail) {
        $result = DB::table('prodotti')
                ->join('listini_detail', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                ->join('immagini', 'immagini.prodotto', '=', 'prodotti.id')
                ->where('prodotti.cancellato', '=', false)
                ->where('listini_detail.cancellato', '=', false)
                ->where('listini_master.cancellato', '=', false)
                ->where('immagini.cancellato', '=', false)
                ->where('listini_detail.id', '=', $id_detail)
                ->select('listini_detail.id as id_prodotto', 'prodotti.titolo', 'listini_detail.prezzo as prezzo', 'immagini.url as url_img', 'immagini.nome as nome_img','prodotti.quantita as quantita')
                ->first();
        return $result;
    }

}
