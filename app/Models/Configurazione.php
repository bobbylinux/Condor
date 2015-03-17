<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;

class Configurazione extends BaseModel {

    protected $table = 'configurazione';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('titolo', 'lingua', 'sfondo');

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
        'titolo' => 'required|min:3|max:255',
        'logo' => 'min:3|max:4000',
        'sfondo' => 'required|max:7',
        'lingua' => 'required|max:2'
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
        
            $this->titolo = $data['titolo'];
            $this->logo = $data['logo'];
            $this->sfondo = $data['sfondo'];
            $this->lingua = $data['lingua'];
            self::save();
    }

    /**
     * The function for update in database from view
     *
     * @data array
     */
    public function refresh($data) {       
            $this->titolo = $data['titolo'];
            $this->logo = $data['logo'];
            $this->sfondo = $data['sfondo'];
            $this->lingua = $data['lingua'];
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
    
    
}
