<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Response as Response;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\URL as URL;

use App\Models\ListinoMaster as ListinoMaster;
use App\Models\ListinoDetail as ListinoDetail;

class ListiniController extends BaseController {

    public $layout = 'template.back';
    protected $listino_master;
    protected $listino_detail;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(ListinoMaster $listino_master, ListinoDetail $listino_detail) {
        $this->listino_master = $listino_master;
        $this->listino_detail = $listino_detail;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(ListinoMaster $listino_master, ListinoDetail $listino_detail) {
        $this->listino_master = $listino_master;
        $this->listino_detail = $listino_detail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data['listino_lista'] = $this->listino_master->where('cancellato', '=', 'false')->orderBy('nome', 'asc')->paginate(10);
        return view('listini.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('listini.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = array(
            'codice' => Input::get('codice_listino'),
            'nome' => Input::get('nome_listino'),
            'data_inizio' => Input::get('data_inizio'),
            'data_fine' => Input::get('data_fine')
        );
        if ($this->listino_master->validate($data)) {
            $last_id = $this->listino_master->store($data);
            $data['listino_master'] = $this->listino_master->find($last_id);            
            return Redirect::to('listini/' . $last_id . '/detail')->with($data);
            //$this->layout->content = View::make('listini.detail', $data);
        } else {
            $errors = $this->listino_master->getErrors();
            return Redirect::action('ListiniController@create')->withInput()->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $data['listino'] = $this->listino_master->find($id);
        return view('listini.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = array(
            'codice' => Input::get('codice_listino'),
            'nome' => Input::get('nome_listino'),
            'data_inizio' => Input::get('data_inizio'),
            'data_fine' => Input::get('data_fine')
        );
        $listino_master = $this->listino_master->find($id);
        if ($listino_master->validate($data)) {
            $listino_master->refresh($data);
            return Redirect::action('ListiniController@index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $listino_detail = $this->listino_detail->where('listino', '=', $id)->get();
        $error = false;

        foreach ($listino_detail as $detail) {
            if (!$detail->trash()) {
                $error = true;
            }
        }
        if (!$error) {
            $result = true;
        }

        $listino_master = $this->listino_master->find($id);
        $result = $listino_master->trash();

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

    /**
     * Open the detail view after a master insert
     *
     * @return Response
     */
    public function detail($id) {
        $data['listino_master'] = $this->listino_master->find($id);
        $data['listino_detail'] = $this->listino_detail->getDetailForMaster($id);
        return view('listini.detail', $data);
    }

    /**
     * Store into listini_detail product
     * 
     * @param type $id
     */
    public function storeDetail() {
        $index = Input::get("index");
        $prezzo = Input::get("prezzo");
        $sconto = Input::get("sconto");
        $codice = Input::get("codice");
        $titolo = Input::get("titolo");
        $prodotto = Input::get("prodotto");
        $listino = Input::get("listino");
        
        $prezzo = str_replace(',', '.', $prezzo);
        $prezzo = number_format((float)$prezzo, 2, '.', '');

        $data = array(
            'listino' => $listino,
            'prodotto' => $prodotto,
            'prezzo' => $prezzo,
            'sconto' => $sconto
        );

        if (trim($sconto == "") || $sconto == null) {
            $sconto = 0;
        }

        $result = $this->listino_detail->store($data);
        $csrf_token = csrf_token();
        $url = URL::to('/');
        $id_detail = $this->listino_detail->id;
        if (!$result) {
            $code = 500;
            $result = 'Error in insert into listini_detail';
        } else {
            $code = 200;
            $result = '<tr><td>' . $index . '</td><td>' . $codice . '</td><td>' . $titolo . '<td>' . $prezzo . '</td><td>' . $sconto . '</td><td><a href="" class="btn btn-primary btn-edit-list-prod">Modifica</a></td><td><a href="' . $url . '/listini/' . $listino . '/detail/' . $id_detail . '" data-token="' . $csrf_token . '" class="btn btn-danger btn-cancella">Elimina</a></td></tr>';
        }

        return Response::json(array(
                    'code' => $code, //OK
                    'prodotto' => $this->listino_detail->prodotto,
                    'msg' => $result
        ));
    }
    
    /**
     * Update into listini_detail product
     * 
     * @param type $id
     */
    public function updateDetail() {
        $prodotto = Input::get("prodotto");
        $prezzo = Input::get("prezzo");
        $sconto = Input::get("sconto");
        
        $prezzo = str_replace(',', '.', $prezzo);
        $prezzo = number_format((float)$prezzo, 2, '.', '');

        $data = array(
            'prodotto' => $prodotto,
            'prezzo' => $prezzo,
            'sconto' => $sconto
        );

        if (trim($sconto == "") || $sconto == null) {
            $sconto = 0;
        }
        
        $listino_detail = $this->listino_detail->find($prodotto);
        
        $result = $listino_detail->refresh($data);
        
        if (!$result) {
            $code = 500;
            $result = 'Error in update into listini_detail';
        } else {
            $code = 200;
            $result = 'ok';
        }

        return Response::json(array(
                    'code' => $code, //OK
                    'prodotto' => $this->listino_detail->prodotto,
                    'msg' => $result
        ));
    }

    public function prodotti($id) {
        $listino_master = new ListiniMaster;
        $listino_master = $listino_master->getListinoMaster($id);
        $listino_prodotti = new ListiniDetail;
        $listino_prodotti = $listino_prodotti->getDetailsFromMaster($id);
        return view('listino_dettaglio');//View::make('listino.detail')->with('listino_dettaglio', $listino_master[0])->with('listino_prodotti', $listino_prodotti);
    }

    public function addProductToCatalog() {
        $listiniDetail = new ListiniDetail;
        $prodotto = new Prodotti;
        $codice = Input::get('codice');
        $result = $prodotto->getProductByCodeClose($codice)->getData();
        foreach ($result as $key => $value) {
            if ($key == "id") {
                $prodotto = $value;
            }
        }
        $id_prodotto = $prodotto->id;
        $listiniDetail->master = Input::get('id_listino');
        $listiniDetail->prodotto = $id_prodotto;
        $listiniDetail->costo_unitario = Input::get('costo_unitario');
        $listiniDetail->inizio_validita = Input::get('data_inizio');
        $listiniDetail->fine_validita = Input::get('data_fine');
        $listiniDetail->save();
        $index = Input::get('index');
        $titolo = Input::get('titolo');
        $costo_unitario = Input::get('costo_unitario');
        $data_inizio = Input::get('data_inizio');
        $data_fine = Input::get('data_fine');
        $data = '<tr><td>' . $index . '</td><td>' . $codice . '</td><td>' . $titolo . '<td>' . $costo_unitario . '</td><td>' . $data_inizio . '</td><td>' . $data_fine . '</td></tr>';

        return Response::json(array(
                    'code' => '200', //OK
                    'prodotto' => $listiniDetail->prodotto,
                    'msg' => $data,
        ));
    }

    public function deleteDetail($catalog, $id) {
        $listino_detail = $this->listino_detail->find($id);
        $result = $listino_detail->trash();
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

}
