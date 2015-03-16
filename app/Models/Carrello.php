<?php namespace App\Models;

class Carrello extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carrello';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('prodotto,utente');

    /**
     * The array containing the names of database columns taht can't be edited/inserted on storage
     * 
     */
    protected $guarded = array('data_creazione');

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
        'utente' => 'required|integer',
        'prodotto' => 'required|integer',
        'quantita' => 'required|integer|min:1'
    );

    /**
     * The variable for validation rules
     * 
     */
    private $rulesUpdate = array(
        'quantita' => 'required|integer|min:1'
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
     * The function for validate 
     *
     * @data array
     */
    public function validateUpdate($data) {
        $validation = Validator::make($data, $this->rulesUpdate, $this->messages);

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

    public function store($data) {
        /* controllo la quantità nel carrello */
        $this->utente = $data['utente'];
        $this->prodotto = $data['prodotto'];
        $this->quantita = $data['quantita'];
        $result = self::save();
        $this->refreshCartItemsNumber();
        return $result;
    }

    public function showCarrello($utente_id) {
        $result = DB::table('carrello')
                ->join('listini_detail', 'listini_detail.id', '=', 'carrello.prodotto')
                ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                ->join('prodotti', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->join('immagini', 'immagini.prodotto', '=', 'prodotti.id')
                ->where('carrello.cancellato', '=', false)
                ->where('prodotti.cancellato', '=', false)
                ->where('listini_detail.cancellato', '=', false)
                ->where('listini_master.cancellato', '=', false)
                ->where('immagini.cancellato', '=', false)
                ->where('carrello.utente', '=', $utente_id)
                ->orderby('titolo')
                ->select('carrello.prodotto as prodotto_id', 'immagini.url as immagine_url', 'carrello.id as id', 'immagini.nome as immagine_nome', 'prodotti.titolo as prodotto', 'listini_detail.prezzo as prezzo', 'listini_detail.sconto as sconto', 'carrello.quantita as quantita')
                ->get();

        return $result;
    }

    public function getCountCart($utente_id) {
        $result = DB::table('carrello')
                ->join('listini_detail', 'listini_detail.id', '=', 'carrello.prodotto')
                ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                ->join('prodotti', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->where('carrello.cancellato', '=', false)
                ->where('prodotti.cancellato', '=', false)
                ->where('listini_detail.cancellato', '=', false)
                ->where('listini_master.cancellato', '=', false)
                ->where('carrello.utente', '=', $utente_id)
                ->count();

        return $result;
    }

    public function refresh($data) {
        $this->quantita = $data['quantita'];
        $this->save();
        return true;
    }

    public function trash() {
        $this->now = date('Y-m-d H:i:s');
        $this->cancellato = true;
        $this->data_cancellazione = $this->now;
        $this->save();
        return true;
    }

    public function brutal_trash() {
        $this->delete();
        return true;
    }

    /**
     * 
     * Funzione che setta badges
     *      
     */
    public function refreshCartItemsNumber() {
        $utente_carrello = $this->where('utente', '=', Auth::user()->id)->where('cancellato', '=', false)->get();

        $numero_articoli = 0;
        foreach ($utente_carrello as $item) {
            $numero_articoli += $item->quantita;
        }

        Session::put('utente_carrello', $numero_articoli);
        return true;
    }
    
    /*
     * 
     *  Funzione che restituisce il totale del carrello
     *
     *       
     */
    public function getCartPrice($userid) {
        $utente_carrello = DB::table('carrello')
                ->join('listini_detail', 'listini_detail.id', '=', 'carrello.prodotto')
                ->join('listini_master', 'listini_detail.listino', '=', 'listini_master.id')
                ->join('prodotti', 'listini_detail.prodotto', '=', 'prodotti.id')
                ->where('carrello.cancellato', '=', false)
                ->where('prodotti.cancellato', '=', false)
                ->where('listini_detail.cancellato', '=', false)
                ->where('listini_master.cancellato', '=', false)
                ->where('carrello.utente', '=', $userid)
                ->select('listini_detail.prezzo as prezzo','carrello.quantita as quantita')
                ->get();
        $totale = 0;
        foreach ($utente_carrello as $item) {
            $totale += ($item->quantita * $item->prezzo);
        }
        
        return $totale;
    }
}
