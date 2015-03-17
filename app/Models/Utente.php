<?php  namespace App\Models;

use Illuminate\Auth\Authenticatable;
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
        'password' => 'required|alphaNum|min:3',
        'password_c' => 'Same:password'
    );
    private $rulesLogin = array(
        'username' => 'required|email', // make sure the email is an actual email
        'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
    );
    private $rulesSignin = array(
        'username' => 'required|email|unique:utenti', // make sure the email is an actual email
        'username_c' => 'required|Same:username',
        'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
        'password_c' => 'required|Same:password',
        'ruolo_utente' => 'required|integer'
    );
    
    /*regole per validazione modifica utente*/
    private $rules = array(
        'username' => 'required|email', // make sure the email is an actual email
        'ruolo_utente' => 'numeric'
    );
    private $errors = "";

    /**
     * The function for validate 
     *
     * @data array
     */
    public function validateLogin($data) {
        $validation = Validator::make($data, $this->rulesLogin, $this->messages);

        if ($validation->fails()) {
            // set errors and return false
            $this->errors = $validation->errors();
            return false;
        }

        return true;
    }

    /**
     * The function for validate sigin
     *
     * @data array
     */
    public function validateSignin($data) {
        $validation = Validator::make($data, $this->rulesSignin, $this->messages);

        if ($validation->fails()) {
            // set errors and return false
            $this->errors = $validation->errors();
            return false;
        }

        return true;
    }

    /*
     * The function for validate password in reset
     *      
     */

    public function validatePassword($data) {
        $validation = Validator::make($data, $this->rulesPassword, $this->messages);

        if ($validation->fails()) {
            // set errors and return false
            $this->errors = $validation->errors();
            return false;
        }

        return true;
    }
    
    public function validate($data) {
        $validation = Validator::make($data, $this->rules, $this->messages);

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

        if ($this->confermaSignIn()) {
            self::save();
            return true;
        } else {
            return false;
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
        $this->codice_conferma = $data['conferma'];
        $this->username = $data['username'];
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

}
