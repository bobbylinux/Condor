<?php
namespace App\Lib\Storage\Prodotto;

interface ProdottoRepository
{

    public function index();

    public function store();

    public function show($id);

    public function update($id);

    public function destroy($id);

}