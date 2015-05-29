<?php
namespace App\Lib\Storage\Categoria;


interface CategoriaRepository
{

    public function index();

    public function store();

    public function show($id);

    public function update($id);

    public function destroy($id);

    public function getAllActivesList();

}