<?php
namespace App\Lib\Storage\Prodotto;

use App\Models\Prodotto as Prodotto;
use App\Lib\Storage\Prodotto\ProdottoRepository as ProdottoRepository;
use App\Http\Controllers\DestinatarioController as ProdottoController;

class EloquentProdottoRepository implements ProdottoRepository
{

    private $prodotto;

    public function __construct(Prodotto $prodotto)
    {
        $this->prodotto = $prodotto;
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

    public function show($id)
    {
    }

    public function update($id)
    {
        
    }

    public function destroy($id)
    {
        
    }

}