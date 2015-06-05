<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Lib\Storage\Destinatario\DestinatarioRepository as Destinatario;

class DestinatariController extends BaseController
{
    protected $destinatario;
    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Destinatario $destinatario)
    {
        $this->destinatario = $destinatario;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['destinatari_lista'] = $this->destinatario->index();
        return view('destinatari.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('destinatari.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->destinatario->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data['destinatario'] = $this->destinatario->show($id);
        return view('destinatari.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
