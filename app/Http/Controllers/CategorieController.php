<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Lib\Storage\Categoria\CategoriaRepository as Categoria;

class CategorieController extends BaseController
{
    protected $categoria;
    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categorie_lista =  $this->categoria->index();
        return view('categorie.index',compact('categorie_lista'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categorie_padre = $this->categoria->getAllActivesList();
        return view('categorie.create',compact('categorie_padre'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\View\View
     */
    public function store()
    {
        $this->categoria->store();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $categorie_padre = $this->categoria->getAllActivesList();
        $categoria = $this->categoria->show($id);
        return view('categorie.edit',compact('categorie_padre','categoria'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $this->categoria->update($id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = $this->categoria->destroy($id);
        if ($result) {
            return \Response::json(array(
                        'code' => '200', //OK
                        'msg' => 'OK'));
        } else {
            return \Response::json(array(
                        'code' => '500', //KO
                        'msg' => 'KO'));
        }
    }
}
