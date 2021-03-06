<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;

class Pagamento extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pagamenti';

    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('pagamento');

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
        'pagamento' => 'required|max:255',
        'nota' => 'max:4000'
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
        $this->pagamento = $data['pagamento'];
        $this->note = $data['note'];
        $result = self::save();
        return $result;
    }
    
    public function refresh($data) {
        $this->pagamento = $data['pagamento'];
        $this->note = $data['note'];
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
