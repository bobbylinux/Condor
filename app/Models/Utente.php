<?php  namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Mail as Mail;

class Utente extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'utenti';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');
    // validate the info, create rules for the inputs
    /**
     * The variable for validation rules
     * 
     */
    private $rulesPassword = array(
        'username' => 'required|email', // make sure the email is an actual email
        'password' => 'required|alphaNum|min:6',
        'password_c' => 'Same:password'
    );
    private $rulesLogin = array(
        'username' => 'required|email', // make sure the email is an actual email
        'password' => 'required|alphaNum|min:6' // password can only be alphanumeric and has to be greater than 3 characters
    );
    private $rulesSignin = array(
        'username' => 'required|email|unique:utenti', // make sure the email is an actual email
        'username_c' => 'required|Same:username',
        'password' => 'required|alpha_dash|min:6', // password can only be alphanumeric and has to be greater than 6 characters
        'password_c' => 'required|Same:password',
        'ruolo_utente' => 'required|integer'
    );
    private $rulesChangePassword = array(
        'username' => 'required|email|exists:utenti,username', // make sure the email is an actual email
    );
    /*regole per validazione modifica utente*/
    private $rules = array(
        'username' => 'required|email', // make sure the email is an actual email
        'ruolo_utente' => 'numeric'
    );
    private $errors = "";
    
    public function validate($data, $method="Default") {
        /*scelgo in base al tipo di validazione*/
        switch ($method) {
            case 'Login':
                $rules = $this->rulesLogin;
                break;
            case 'Signin':
                $rules = $this->rulesSignin;
                break;
            case 'Password':
                $rules = $this->rulesPassword;
                break;
            case 'ChangePassword':
                $rules = $this->rulesChangePassword;
                break;
            case 'Default':
                $rules = $this->rules;
                break;
            default:
                $rules = $this->rules;
        }
        
        $validation = Validator::make($data, $rules, $this->messages);

        if ($validation->fails()) {
            // set errors and return false
            $this->errors = $validation->errors();
            return false;
        }

        return true;
    }
    /**
     * The function that incapsulate the error variable
     * 
     * @errors array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * The function that store user in database with confermation code
     * 
     * @result boolean
     */
    public function store($data) {
        $this->username = $data['username'];
        $this->password = Hash::make($data['password']);
        $this->codice_conferma = $data['conferma'];
        $this->ruolo = $data['ruolo_utente'];
        if (isset($data['confermato'])) {
            $this->confermato = $data['confermato'];
        }
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isSuperUser())) {
            if ($this->confermaSignIn()) {
             self::save();
             return true;
            } else {
             return false;
            }
        } else {
            self::save();
            return true;
        }
    }

    /**
     * The function that send an e-mail with confermation link
     * 
     * @result boolean
     */
    private function confermaSignIn() {
        $data['codice'] = $this->codice_conferma;
        Mail::send('emails.verify', $data, function($message) {
            $message->to($this->username, $this->username)
                    ->subject('Verifica indizzo e-mail');
        });
        return true;
    }

    private function confermaResetPwd() {
        $data['codice'] = $this->codice_conferma;
        Mail::send('emails.reset', $data, function($message) {
            $message->to($this->username, $this->username)
                    ->subject('Reset password');
        });
        return true;
    }

    /* reset della password */

    public function resetPassword($data) {
        $this->username = $data['username'];
        $this->codice_conferma = $data['conferma'];
        if ($this->confermaResetPwd($data)) {
            $utente = $this->where('username', '=', $data['username'])->where('cancellato', '=', false)->first();
            $utente->codice_conferma = $data['conferma'];
            $utente->save();
            return true;
        } else {
            return false;
        }
    }

    public function updatePassword($data) {
        $utente = $this->where('username', '=', $data['username'])->where('cancellato', '=', false)->first();
        $utente->codice_conferma = null;
        $utente->password = Hash::make($data['password']);
        $utente->save();
        return true;
    }
    
     /**
     * The function for update in database from view
     *
     * @data array
     */
    public function refresh($data) {
        $this->username = $data['username'];
        $this->ruolo = $data['ruolo_utente'];
        $this->save();
        return true;
    }
    /**
     * The function for delete in database from view
     *
     * @data array
     */
    public function trash() {
        $this->now = date('Y-m-d H:i:s');
        $this->cancellato = true;
        $this->data_cancellazione = $this->now;
        $this->save();
        return true;
    }
    
    public function disable() {
        $this->confermato = false;
        $this->save();
        return true;        
    }
    
    public function enable() {
        $this->confermato = true;
        $this->save();
        return true;
    }
    
    /**
     * The function for know if user is an admin or not
     *
     * @data array
     */
    public function isAdmin() {
        if ($this->ruolo == 2) {
            return true; 
        } else {
            return false;
        }
    }
    
    /**
     * The function for know if user is a superuser or not
     *
     * @data array
     */
    public function isSuperUser() {
        if ($this->ruolo == 3) {
            return true; 
        } else {
            return false;
        }
    }
   
}
