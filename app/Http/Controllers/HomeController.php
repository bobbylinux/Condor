<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Prodotto as Prodotto;
use App\Models\Categoria as Categoria;
use App\Models\Valuta as Valuta;
use App\Models\ListinoDetail as ListinoDetail;
use Illuminate\Support\Facades\Input as Input;

class HomeController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public $layout = 'template.front';

    public function showWelcome() {
        //$this->layout->content = \View::make('index');
    }

    public function showInfo() {
        //$this->layout->content = \View::make('info');
    }

    /**
     * Function that show actived catalog category from id in input (category_id)
     * 
     * @param Integer $id
     */
    public function showCategory($id) {
        if ($id != null) {
            $prodotto = new Prodotto;
            $data['prodotti_lista'] = $prodotto->showCategory($id);
            $categoria = new Categoria;
            $data['categoria_lista'] = $categoria->getActives();
            return view('index',$data);//View::make('index', $data);
        }
    }

    public function showCatalog() {
        $prodotto = new Prodotto;
        $data['prodotti_lista'] = $prodotto->showActives();
        $categoria = new Categoria;
        $data['categoria_lista'] = $categoria->getActives();
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        return view('index',$data);//$this->layout->content = \View::make('index', $data);
    }

    public function showProduct($id) {
        $prodotto = new ListinoDetail;
        $categoria = new Categoria;
        $data['categoria_lista'] = $categoria->getActives();
        $data['prodotto'] = $prodotto->searchById($id);
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        return view('catalogo.prodotto',$data);//$this->layout->content = \View::make('catalogo.prodotto', $data);
    }

    /*
     *  Metodo per la ricerca dei prodotti nella navbar
     *  
     *      
     */

    public function searchProduct() {
        $chiave = trim(Input::get('ricerca'));
        $prodotto = new ListinoDetail;
        $categoria = new Categoria;
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        $data['categoria_lista'] = $categoria->getActives();
        $data['prodotti_lista'] = $prodotto->searchByTitle($chiave, 'like');
        return view('index',$data);//$this->layout->content = \View::make('index', $data);
    }

}
