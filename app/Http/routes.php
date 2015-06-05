<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

/* Info page */
Route::get('/info','HomeController@showInfo');

/* Test page */
Route::get('/test', function() {
    return view('test');
});

/* Test page */
Route::get('/upload', function() {
    return view('upload');
});
Route::post('/immagini/upload', 'ImmaginiController@imgUpload');
/*fine test*/

/*set the specified language*/
Route::get('/language/{lang}', function($lang) {
    Session::put('lang', $lang);
    App::setLocale($lang);
    return Redirect::action('DashController@showDashboard');
});
/* Home page */
Route::get('/', 'HomeController@showCatalog');
/* rimanda alla pagina della registrazione */
Route::get('/signin', ['middleware' => 'guest', 'uses' =>'UtentiController@showSignIn']);
/* effettua la registrazione */
Route::post('/signin', ['middleware' => 'guest', 'uses' =>'UtentiController@doSignIn']);
/* conferma la registrazione */
Route::get('signin/verify/{confirmationCode}', ['middleware' => 'guest', 'uses' => 'UtentiController@confirmSignin']);

/* Reset Password */
Route::get('password/reset', 'UtentiController@resetPassword');
Route::post('password/reset', 'UtentiController@doResetPassword');
Route::post('password/update', 'UtentiController@updatePassword');
Route::get('password/reset/{confirmationCode}', 'UtentiController@confirmResetPwd');
/* Authentication/Login */
Route::get('login', ['middleware' => 'guest', 'uses' => 'UtentiController@showLogin']);
/* Post Login */
Route::post('login', 'UtentiController@dologin');

/* Logout */
Route::get('logout', ['middleware' => 'auth', 'uses' => 'UtentiController@doLogout']);
/* show categoria */
Route::get('catalogo/categoria/{id}', 'HomeController@showCategory');
/* show dettaglio prodotto */
Route::get('catalogo/prodotto/{id}', 'HomeController@showProduct');
/* show dettaglio prodotto */
Route::post('catalogo/search', 'HomeController@searchProduct');

Route::group(array('middleware' => 'superuser'), function() {
    /* RESTful per valute */
    Route::resource('valute', 'ValuteController');
    /* RESTful per utenti */
    Route::resource('utenti', 'UtentiController');
    /* RESTful per utenti */
    Route::resource('configurazione', 'ConfigurazioneController');
});

Route::group(array('middleware' => 'auth'), function() {
    /* RESTful per carrello */
    Route::resource('carrello', 'CarrelliController');
    Route::post('order/store', 'OrdiniController@store');
    Route::post('order/codetemp', 'OrdiniController@getTempCode');
    Route::get('order/history', 'OrdiniController@userOrders');
    Route::get('address/create', 'OrdiniController@newAddress');
    Route::post('order/confirm', 'OrdiniController@orderConfirm');
    Route::get('order/confirm', 'OrdiniController@orderConfirm');
    Route::post('address/select', 'OrdiniController@chooseAddress');
    Route::post('address/store', 'OrdiniController@storeAddress');
    Route::resource('destinatari', 'DestinatariController');
});

Route::group(array('middleware' => 'admin'), function() {

    /* Get per area utenti */
    Route::get('dashboard', 'DashController@showDashboard');
    /* RESTful per categorie */
    Route::resource('categorie', 'CategorieController');
    /* RESTful per prodotti */
    Route::resource('prodotti', 'ProdottiController');
    /* RESTful per immagini */
    Route::resource('immagini', 'ImmaginiController');
    /* RESTful per listini */
    Route::resource('listini', 'ListiniController');
    /* RESTful per pagamenti */
    Route::resource('pagamenti', 'PagamentiController');
    /* RESTful per pagamenti */
    Route::resource('pagamenti', 'PagamentiController');
    /* RESTful per spedizioni */
    Route::resource('spedizioni', 'SpedizioniController');
    /* RESTful per ordini */
    Route::resource('ordini', 'OrdiniController');
    Route::post('ordini/{id}/detail', 'OrdiniController@detail');
    Route::post('ordini/{id}/update', 'OrdiniController@aggiorna');
    Route::post('ordini/{id}/update/stato', 'OrdiniController@setStato');
    Route::post('ordini/{id}/pagato', 'OrdiniController@pagato');
    /* aggiornamento del listino detail da master */
    Route::get('listini/{id}/detail', 'ListiniController@detail');
    /* gestione post su ricerca ajax dei prodotti nel catalogo */
    Route::post('listini/{id}/prodotto/ricerca/codice/{type}', 'ProdottiController@searchByCode');
    Route::post('listini/{id}/prodotto/ricerca/titolo/{type}', 'ProdottiController@searchByTitle');
    Route::post('prodotto/ricerca/codice/{type}', 'ProdottiController@searchByCode');
    Route::post('prodotto/ricerca/titolo/{type}', 'ProdottiController@searchByTitle');
    Route::delete('listini/{id}/detail/{detail}', 'ListiniController@deleteDetail');
    Route::delete('prodotto/{idProduct}/immagine/{idImage}', 'ProdottiController@detachImage');
    /* aggiunta prodotto a lisino_detail */
    Route::post('listini/{id}/prodotto/aggiungi', 'ListiniController@storeDetail');
    /* aggiornamento prodotto del lisino_detail */
    Route::post('listini/{id}/prodotto/aggiorna', 'ListiniController@updateDetail');
    /* abilita / disabilita utenti */
    Route::post('utenti/{id}/status/{status}', 'UtentiController@toggle');
});
