<?php
namespace App\Lib\Storage\Destinatario;

use App\Models\Destinatario as Destinatario;
use App\Lib\Storage\Destinatario\DestinatarioRepository as DestinatarioRepository;
use App\Http\Controllers\DestinatarioController as DestinatarioController;

class EloquentDestinatarioRepository implements DestinatarioRepository
{

    private $destinatario;

    public function __construct(Destinatario $destinatario)
    {
        $this->destinatario = $destinatario;
    }

    public function index()
    {
        return $this->destinatario->where('utente', '=', \Auth::user()->id)->where('cancellato', '=', false)->get();
    }

    public function store($data)
    {
        if ($this->destinatario->validate($data)) {
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
            $result = $this->destinatario->save();
            return \Redirect::action('OrdiniController@orderConfirm');
        }  else {
            $errors = $this->destinatario->getErrors();
            return \Redirect::action('OrdiniController@newAddress')->withInput()->withErrors($errors);
        }

    }
    
    public function show($id) {
        return $this->destinatario->find($id);
    }

    public function update($id)
    {
        
    }

    public function destroy($id)
    {
        
    }

}