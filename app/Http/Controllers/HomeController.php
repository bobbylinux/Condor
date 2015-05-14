<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Prodotto as Prodotto;
use App\Models\Categoria as Categoria;
use App\Models\Valuta as Valuta;
use App\Models\ListinoDetail as ListinoDetail;
use Illuminate\Support\Facades\Input as Input;

class HomeController extends BaseController
{
    /**
     * Function that show the phpInfo()
     *
     * @param  none
     * @return Illuminate\View\View
     */
    public function showInfo()
    {
        return view('info');
    }
    /**
     * Function that show actived catalog category from id in input (category_id)
     * 
     * @param Integer $id
     * @return Illuminate\View\View
     */
    public function showCategory($id)
    {
        if ($id != null) {
            $prodotto = new Prodotto;
            $data['prodotti_lista'] = $prodotto->showCategory($id);
            $categoria = new Categoria;
            $data['categoria_lista'] = $categoria->getActives();
            return view('index',$data);
        }
    }
    /**
     * Function that show the catalog actived in home page
     *
     * @param Integer $id
     * @return Illuminate\View\View
     */
    public function showCatalog()
    {
        $prodotto = new Prodotto;
        $data['prodotti_lista'] = $prodotto->showActives();
        $categoria = new Categoria;
        $data['categoria_lista'] = $categoria->getActives();
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        return view('index',$data);//$this->layout->content = \View::make('index', $data);
    }
    /**
     * Function that show the detail for specified product in home page
     *
     * @param Integer $id
     * @return Illuminate\View\View
     */
    public function showProduct($id)
    {
        $prodotto = new ListinoDetail;
        $categoria = new Categoria;
        $data['immagini'] = $prodotto->getProductImages($id);
        $data['prodotto'] = $prodotto->searchById($id);
        $valuta = new Valuta;
        $data['valuta'] = $valuta->getValuta();
        return view('catalogo.prodotto',$data);//$this->layout->content = \View::make('catalogo.prodotto', $data);
    }
    /*
     *  Function the search specified product by specified string
     *
     *  @param none
     *  @return Illuminate\View\View
     */
    public function searchProduct()
    {
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
