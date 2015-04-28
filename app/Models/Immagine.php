<?php namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;

class Immagine extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'immagini';
    
    /**
     * The array containing the names of database columns that can't be empty on storage
     * 
     */
    protected $fillable = array('nome', 'url', 'tipo');

    /**
     * The array containing the names of database columns taht can't be edited/inserted on storage
     * 
     */
    protected $guarded = array('data_creazione');
    
    /**
     * The variable for validation rules
     * 
     */
    private $rules = array(
        'nome' => 'required|min:1|max:64',
        'url' => 'required|min:1|max:4000',
        'tipo' => 'required|min:2|max:32',
        'file' => 'mimes:jpg,jpeg,png'        
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
    public function store($data,$file) {
        $this->nome = $data['nome'];
        $this->url = $data['url'];
        $this->tipo = $data['tipo'];
        $result = self::save();
        if ($result) {
            $file->move($data['url'], $data['nome']);
        }
        
    }
    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function prodotti() {
        return $this->belongsToMany('App\Models\Prodotto','immagini_prodotti','immagine','prodotto');
    }
    
    public function getFirstImage($id_prodotto) {
        $prodotto = Prodotti::find($id_prodotto);
	return $prodotto->immagine()->where('cancellato','=',false)->first();
    }

}
