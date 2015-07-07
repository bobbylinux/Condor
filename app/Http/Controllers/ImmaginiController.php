<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Response as Response;
use App\Http\Controllers\Controller;
use App\Models\Immagine as Immagine;

class ImmaginiController extends Controller {

    private $immagine;

    /**
     * Constructor for Dipendency Injection
     *
     * @return none
     *
     */
    public function __construct(Immagine $immagine) {
        $this->immagine = $immagine;
    }

    /**
     * Setter for Dipendency Injection
     *
     * @return none
     *
     */
    public function setInjection(Carrello $carrello) {
        $this->carrello = $carrello;
    }

    /**
     * Get a new instance of an elemente Immagine
     *
     * @return Response
     */
    public function getImageInstance(Immagine $immagine) {
        return new $immagine;
    }

    /**
     * Display a listing of the resource.
     *
     * @return none
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return none
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* validazione immagini */
        $cartella_random = str_random(15);

        $url_file = 'uploads/' . $cartella_random;
        $index = "file-0"; // . $i;
        Input::file($index)->move($url_file);
        $idx_imgs = array(); //indici delle immagini appena inserite da collegare al prodotto una volta salvato quest'ultimo
        if (Input::hasFile('files')) {
            foreach (Input::file('files') as $file) {
                $nome_file = $file->getClientOriginalName();
                $tipo_file = $file->guessClientExtension();
                $data_img = array(
                    'nome' => $nome_file,
                    'url' => $url_file,
                    'tipo' => $tipo_file,
                    'file' => $file);
                if (!$this->immagine->validate($data_img)) {
                    $errors = $this->immagine->getErrors();
                    return Response::json(array(
                                'code' => '500', //KO
                                'msg' => 'KO',
                                'errors' => $errors));
                }
            }

            foreach (Input::file('files') as $file) {
                $nome_file = $file->getClientOriginalName();
                $tipo_file = $file->guessClientExtension();
                $data_img = array(
                    'nome' => $nome_file,
                    'url' => $url_file,
                    'tipo' => $tipo_file);
                $immagine = $this->getImageInstance($this->immagine); //questo è un utilizzo casareccio della Dependency Injection, almeno come io l'ho concepita....
                $immagine->store($data_img, $file);
                array_push($idx_imgs, $immagine->id);
            }
            return Response::json(array(
                        'code' => '200', //OK
                        'msg' => 'OK',
                        'img' => Response::json($idx_imgs)));
        } else {
            return Response::json(array(
                        'code' => '500', //KO
                        'msg' => 'no file in input'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->immagine->find($id)->trash();
        if ($result) {
            return Response::json(array(
                        'code' => '200', //OK
                        'msg' => 'OK'));
        } else {
            return Response::json(array(
                        'code' => '500', //KO
                        'msg' => 'KO'));
        }
    }

    public function imageUpload() {

        $file = Input::file('file');
        if ($file) {
            $destinationPath = public_path() . '/uploads/temp';
            $filename = $file->getClientOriginalName();
            $upload_success = Input::file('file')->move($destinationPath, $filename);

            if ($upload_success) {
                // resizing an uploaded file
                //Image::make($destinationPath . $filename)->resize(100, 100)->save($destinationPath . "100x100_" . $filename);
                return Response::json('success', 200);
            } else {
                return Response::json('error', 400);
            }
        }
    }

    public function imageDelete() {
        
    }

}
