<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;

class ListinoMaster extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'listini_master';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('codice', 'nome');

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
        'codice' => 'required|min:2|max:32',
        'nome' => 'max:128'
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
        $this->nome = $data['nome'];
        $data['data_inizio'] = str_replace('/', '-', $data['data_inizio']);
        $data['data_fine'] = str_replace('/', '-', $data['data_fine']);
        $this->data_inizio = date("Y-m-d", strtotime($data['data_inizio']));
        $this->data_fine = date("Y-m-d", strtotime($data['data_fine']));
        self::save();
        $last_id = $this->id;
        return $last_id;
    }

    /**
     * The function for update in database from view
     *
     * @data array
     */
    public function refresh($data) {
        $this->codice = $data['codice'];
        $this->nome = $data['nome'];
        $data['data_inizio'] = str_replace('/', '-', $data['data_inizio']);
        $data['data_fine'] = str_replace('/', '-', $data['data_fine']);
        $this->data_inizio = date("Y-m-d", strtotime($data['data_inizio']));
        $this->data_fine = date("Y-m-d", strtotime($data['data_fine']));
        $this->save();
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
        $this->save();
        return true;
    }

    /**
     * The function return all actives catalogs
     *
     * @data array
     */
    public function getActives() {
        $this->now = date('Y-m-d');
        $result = $this->whereRaw('current_timestamp between data_inizio and data_fine')->get();
        return $result;
    }

    // each listino have many details
    public function prodotti() {
        return $this->belongsToMany('Prodotto', 'listini_detail', 'listino', 'prodotto')->withPivot("prezzo", "sconto","id");
    }

}
