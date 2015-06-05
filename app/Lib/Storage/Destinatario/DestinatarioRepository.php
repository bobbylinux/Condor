<?php
namespace App\Lib\Storage\Destinatario;

interface DestinatarioRepository
{

    public function index();

    public function store($data);
    
    public function show($id);

    public function update($id);

    public function destroy($id);

}