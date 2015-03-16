<?php

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
    protected $fillable = array('nome', 'url', 'tipo', 'prodotto');

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
        $nome_file = $data['nome'];
        $url_file = $data['url'];
        $tipo_file = $data['tipo'];
        $prodotto_file = $data['prodotto'];
        $this->nome = $nome_file;
        $this->url = $url_file;
        $this->tipo = $tipo_file;
        $this->prodotto = $prodotto_file; 
        $result = self::save();
        if ($result) {
            $file->move($url_file, $nome_file);
        }
        
    }
    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function prodotto() {
        return $this->belongsTo('Prodotto');
    }
    
    public function getFirstImage($id_prodotto) {
        $this->immagine->where('prodotto','=',$id_prodotto)->where('cancellato','=',false)->first();
    }

}
