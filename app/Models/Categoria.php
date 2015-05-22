<?php namespace App\Models;

class Categoria extends BaseModel {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categorie';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('nome');

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
        'nome' => 'required|min:2|max:255',
        'descrizione' => 'max:4000',
        'padre' => 'integer|min:0'
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
        $validation = \Validator::make($data, $this->rules, $this->messages);

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

    }

    public function getActives() {
        $this->now = date('Y-m-d H:i:s');
        $result = \DB::table('categorie')
                ->join('categorie_prodotti', 'categorie_prodotti.categoria', '=', 'categorie.id')
                ->join('listini_detail','listini_detail.prodotto','=','categorie_prodotti.prodotto')
                ->join('listini_master','listini_detail.listino','=','listini_master.id')
                ->where('categorie_prodotti.cancellato', '=', false)
                ->where('categorie.cancellato', '=', false)
                ->where('listini_detail.cancellato','=',false)
                ->where('listini_master.cancellato','=',false)
                ->where('listini_master.data_inizio','<=',$this->now)
                ->where('listini_master.data_fine','>=',$this->now)
                ->select('categorie.id as id','categorie.nome as nome')->distinct()
                ->orderBy('nome', 'asc')->get();
        return $result;
    }

    public function prodotto() {
        return $this->hasMany('Prodotto', 'categoria');
    }

    public function padre() {
        return $this->belongsTo('Categoria', 'padre');
    }

    public function figlio() {
        return $this->hasMany('Categoria', 'padre');
    }

}
