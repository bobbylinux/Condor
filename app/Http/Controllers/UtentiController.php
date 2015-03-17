<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Response as Response;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Utente as Utente;
use App\Models\Carrello as Carrello;
use App\Models\RuoloUtente as RuoloUtente;

class UtentiController extends BaseController {

    //public $layout = 'template.front';
    protected $utente;

    /**
     * Constructor for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function __construct(Utente $utente) {
        $this->utente = $utente;
    }

    /**
     * Setter for Dipendency Injection
     * 
     * @return none
     *          
     */
    public function setInjection(Utente $utente) {
        $this->utente = $utente;
    }

    public function showLogin() {
        // show the form
        return view('utenti.login');
    }

    public function showSignIn() {
        return view('utenti.signin');
    }

    /**
     * Metodo di login get
     * 
     * @return view
     *          
     */
    public function doLogin() {
        // create our user data for the authentication
        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

        if ($this->utente->validateLogin($userdata)) {
            // attempt to do the login
            if (Auth::attempt($userdata)) {
                if (Auth::user()->cancellato) {
                    Auth::logout();
                    // validation not successful, send back to form	
                    $errors = $this->categoria->getErrors();
                    return Redirect::to('login')->withErrors($errors)->withInput(Input::except('password'));
                    ;
                } else {
                    $carrello = new Carrello;
                    $carrello->refreshCartItemsNumber();

                    Session::put('utente_user', $userdata['username']);
                    Session::put('utente_id', Auth::user()->id);
                    Session::put('utente_ruolo', Auth::user()->ruolo);
                    switch (Auth::user()->ruolo) {
                        case 1: //user standard
                            return Redirect::to('/');
                            break;
                        case 2: //user admin
                            return Redirect::to('dashboard');
                            break;
                        case 3: //user super
                            return Redirect::to('dashboard');
                            break;
                    }
                }
            } else {
                // validation not successful, send back to form	
                return Redirect::to('login')->with('errore_auth', Lang::choice('messages.errore_auth', 0))->withInput(Input::except('password'));
            }
        } else {
            $errors = $this->utente->getErrors();
            return Redirect::to('login')->withErrors($errors)->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        }
    }

    public function doLogout() {
        Auth::logout(); // log the user out of our application
        Session::flush();
        return Redirect::to('/'); // redirect the user to the login screen
    }

    public function doSignin() {
        // create our user data for the authentication
        $userdata = array(
            'username' => Input::get('username'),
            'username_c' => Input::get('username_c'),
            'password' => Input::get('password'),
            'password_c' => Input::get('password_c'),
            'conferma' => str_random(30),
            'ruolo' => 1
        );

        if ($this->utente->validateSignin($userdata)) {
            $result = $this->utente->store($userdata);
            if ($result) {
                $data['conferma'] = 'Controlla la tua mail per confermare la registrazione';
                $data['errore'] = false;
                $data['titolo'] = "Conferma";
                return view('utenti.conferma',$data);//$this->layout->content = View::make('utenti.conferma', $data);
            } else {
                return Redirect::to('signin')->withErrors(['msg', 'Si &egrave; verificato un errore, contattare l\'amministratore del sistema']);
            }
        } else {
            $errors = $this->utente->getErrors();
            return Redirect::to('signin')->withErrors($errors)->withInput(Input::except('password', 'password_c')); // send back the input (not the password) so that we can repopulate the form
        }
    }

    public function confirmSignin($confirmationCode) {
        $confirmation_code = $confirmationCode;
        if (!$confirmation_code) {
            $data['conferma'] = 'Nessun codice presente, contattare l\'amministratore del sistema';
            $data['errore'] = true;
            $data['titolo'] = "Errore";
            return view('utenti.conferma',$data);//$this->layout->content = View::make('utenti.conferma', $data);
        }

        $user = $this->utente->where('codice_conferma', '=', $confirmation_code)->first();

        if (!$user) {
            $data['errore'] = true;
            $data['titolo'] = "Errore";
            $data['conferma'] = 'Codice non valido, contattare l\'amministratore del sistema';
            return view('utenti.conferma',$data);//$this->layout->content = View::make('utenti.conferma', $data);
        } else {

            $user->confermato = true;
            $user->codice_conferma = null;
            $user->save();
            $data['conferma'] = 'Registazione confermata correttamente. Benvenuto in Condor';
            $data['errore'] = false;
            $data['titolo'] = "Conferma Iscrizione";
            return view('utenti.conferma',$data);
        }
    }

    public function confirmResetPwd($confirmationCode) {
        $confirmation_code = $confirmationCode;
        if (!$confirmation_code) {
            $data['conferma'] = 'Nessun codice presente, contattare l\'amministratore del sistema';
            $data['errore'] = true;
            $data['titolo'] = "Errore";
            return view('utenti.conferma',$data);
        }

        $user = $this->utente->where('codice_conferma', '=', $confirmation_code)->first();

        if (!$user) {
            $data['errore'] = true;
            $data['titolo'] = "Errore";
            $data['conferma'] = 'Codice non valido, contattare l\'amministratore del sistema';
            return view('utenti.conferma',$data);
        } else {
            $data['conferma'] = 'Registazione confermata correttamente. Benvenuto in Condor';
            $data['errore'] = false;
            $data['titolo'] = "Conferma Reset Password";
            $data['username'] = $user->username;
            return view('utenti.conferma',$data);
        }
    }

    public function updatePassword() {
        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'password_c' => Input::get('password_c')
        );
        if ($this->utente->validatePassword($userdata)) {
            $result = $this->utente->updatePassword($userdata);
            if ($result) {
                $data['conferma'] = 'La tua password è stata correttamente cambiata, effettua il login per accedere al sito';
                $data['errore'] = false;
                $data['titolo'] = "Aggiornamento Password";
                return view('utenti.conferma',$data);
            } else {
                return view('utenti.reset');
            }
        }
    }

    public function doResetPassword() {
        $email = Input::get('username');
        /* ricerco l'utente nel database */
        $user = $this->utente->where('username', '=', $email)->where('cancellato', '=', false)->count();
        if ($user == 1) {
            /* se esiste allora devo generare il codice e inviarlo via mail */
            $codice = str_random(30);
            $userdata = array(
                'username' => $email,
                'conferma' => $codice
            );
            $result = $this->utente->resetPassword($userdata);

            if ($result) {
                $data['conferma'] = 'Mail reset password inviata correttamente, controlla la tua casella di posta. ';
                $data['errore'] = false;
                $data['titolo'] = "Mail Reset Password";
                return view('utenti.conferma',$data);
            } else {
                return view('utenti.reset');
            }
        } else {
            
        }
    }

    public function resetPassword() {
        return view('utenti.reset');
    }

    /*
     *  RESTful per utenti 
     *      
     */

    public function index() {

        //$this->layout = View::make('template.back');
        /* recupero tutti gli utenti dalla classe modello */
        $data['utenti_lista'] = $this->utente->where('cancellato', '=', 'false')->orderBy('username', 'asc')->paginate(10);
        /* creo la vista per la visualizzazione della lista degli utenti */
        return view('utenti.index',$data);
    }

    public function create() {
        $ruolo = New RuoloUtente();
        $data['ruolo'] = $ruolo->where('cancellato', '=', 'false')->lists('ruolo', 'id');
        return view('utenti.create',$data);
    }

    public function store() {
        $userdata = array(
            'username' => Input::get('username'),
            'username_c' => Input::get('username_c'),
            'password' => Input::get('password'),
            'password_c' => Input::get('password_c'),
            'conferma' => null,
            'ruolo_utente' => Input::get('ruolo_utente'),
            'confermato' => true
        );

        if ($this->utente->validateSignin($userdata)) {
            $result = $this->utente->store($userdata);
            return Redirect::action('UtentiController@index');
        } else {
            $errors = $this->utente->getErrors();
            return Redirect::action('UtentiController@create')->withErrors($errors)->withInput(Input::except('password', 'password_c'));
        }
    }

    public function edit($id) {
        $ruolo = New RuoloUtente();
        $data['ruolo'] = $ruolo->where('cancellato', '=', 'false')->lists('ruolo', 'id');
        $data['utente'] = $this->utente->find($id);
        //$this->layout = View::make('template.back');
        //$this->layout->content = View::make('utenti.edit', $data);
        return view('utenti.edit',$data);
        
    }

    public function update($id) {
        $data = array(
            'username' => Input::get('username'),
            'ruolo_utente' => Input::get('ruolo_utente')
        );

        $utente = $this->utente->find($id);
        if ($this->utente->validate($data)) {
            $utente->refresh($data);
            return Redirect::action('UtentiController@index');
        } else {
            $errors = $this->utente->getErrors();
            return Redirect::action('UtentiController@edit', [$id])->withInput()->withErrors($errors);
        }
    }

    public function disable($id) {
        $utente = $this->utente->find($id);
        $result = $utente->disable();
        return Redirect::action('UtentiController@index');
    }

    public function enable($id) {
        $utente = $this->utente->find($id);
        $result = $utente->enable();
        return Redirect::action('UtentiController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $utente = $this->utente->find($id);
        $result = $utente->trash();
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
