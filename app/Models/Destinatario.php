<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;

class Destinatario extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'destinatari';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('utente','nome','cognome','indirizzo','citta','cap','provincia','paese');

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
        'nome'=> 'required|max:255',
        'cognome' => 'required|max:255',
        'indirizzo' => 'required|max:500',
        'note' => 'max:255',
        'citta' => 'required|max:255',
        'provincia' => 'max:16',
        'cap' => 'required|max:25',
        'paese'=> 'required|max:255',
        'recapito' => 'max:255'
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

    public function store($data) {
        
    }
    
    public function refresh($data) {
        $this->utente = Auth::user()->id;
        $this->cognome = strtoupper(trim($data['cognome']));
        $this->nome = strtoupper(trim($data['nome']));
        $this->indirizzo = strtolower(trim($data['indirizzo']));
        $this->note = $data['note'];
        $this->citta = strtoupper(trim($data['citta']));
        $this->cap = strtoupper(trim($data['cap']));
        $this->provincia = strtoupper(trim($data['provincia']));
        $this->paese = strtoupper(trim($data['paese']));
        $this->recapito = $data['recapito'];
        $result = $this->save();
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
        $this->save();
        return true;
    }
    

}
