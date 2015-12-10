<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator as Validator;
use \Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFile;

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
     * The variable for system date time
     * 
     */
    protected $now = null;

    /**
     * The variable for base directories
     * 
     */
    protected $baseDir = '/uploads';
    protected $tempDir = '/uploads/temp';

    /**
     * The variable for validation rules
     * 
     */
    private $rules = array(
        'nome' => 'required|min:1|max:512',
        'url' => 'required|min:1|max:4000',
        'tipo' => 'required|min:2|max:32',
        'file' => 'required|mimes:jpg,jpeg,png',
        'dimensione' => 'required|max:2097152'
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
        $this->url = $data['url'];
        $this->tipo = $data['tipo'];
        $result = self::save();
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
     * The function for store temporaney files to crop
     *
     * @data array
     */
    public function addTemp(UploadedFile $file) {
        $photo = new static; 
        
        $name = time() . $file->getClientOriginalName();
         
        $file->move(public_path() . $this->tempDir, $name);

        return $this->tempDir . '/' . $name;
    }

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function prodotti() {
        return $this->belongsToMany('App\Models\Prodotto', 'immagini_prodotti', 'immagine', 'prodotto');
    }

    public function getFirstImage($id_prodotto) {
        $prodotto = Prodotti::find($id_prodotto);
        return $prodotto->immagine()->where('cancellato', '=', false)->first();
    }

}
