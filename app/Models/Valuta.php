<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\DB as DB;

class Valuta extends BaseModel {

    protected $table = 'valute';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('nome', 'simbolo', 'sigla');

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
        'simbolo' => 'required|max:3',
        'sigla' => 'max:6|alpha_num'
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
        
            $this->nome = $data['nome'];
            $this->simbolo = $data['simbolo'];
            $this->sigla = $data['sigla'];
            self::save();
    }

    /**
     * The function for update in database from view
     *
     * @data array
     */
    public function refresh($data) {       
            $this->nome = $data['nome'];
            $this->simbolo = $data['simbolo'];
            $this->sigla = $data['sigla'];
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
    
    public function getValuta() {
        $result = DB::table('valute')
                ->where('cancellato','=',false)
                ->select('nome','simbolo','sigla')
                ->first();
        return $result;
    }
    
}
