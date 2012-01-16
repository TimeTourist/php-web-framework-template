<?php
/**
 *  Class for Authentification uf users...
 */
class Authenticator {
    /**
    * $errorMessage is for storing error messages
    */
    private $errorMessage;

    /**
    * $user is for storing error messages
    */    
    private $user;
 
    //! A constructor.
    /**
    * Constucts a new Authenticator instance
    */
    public function __construct() {
        $this->errorMessage=array();
    }
 
    //! A manipulator
    /**
    * Adds a message to the array
    * @return void
    */
    protected function setError ($message) {
        $this->errorMessage[]=$messge;
    }
 
    //! An accessor
    /**
    * Returns true if there are no errors
    * @return boolean
    */
    public function isAuthenticated () {
        if ( count ($this->errorMessage) > 0 ) {
            return false;
        } else {
            return true;
        }
    }
 
    //! An accessor
    /**
    * return the first error
    * @return string
    */
    public function getError () {
        return array_shift($this->errorMessage);
    }
}
 


 
    //! A constructor.
    /**
    * Constucts a new ValidateUser object
    * @param $user the string to validate
    */
    public function __construct($user) {
        $this->user=$user;
        Validator::__construct();
    }
 
    //! A manipulator
    /**
    * Validates a username
    * @return void
    */
    public function validate() {
        if (!preg_match('/^[a-zA-Z0-9_]+$/',$this->user )) {
            $this->setError('Username contains invalid characters');
        }
        if (strlen($this->user) < 6 ) {
            $this->setError('Username is too short');
        }
        if (strlen($this->user) > 20 ) {
            $this->setError('Username is too long');
        }
    }
}
 
/**
 *  ValidatorPassword subclass of Validator
 *  Validates a password
 */
class ValidatePassword extends Validator {
    /**
    * Private
    * $pass the password to validate
    */
    private $pass;
    /**
    * Private
    * $conf to confirm the passwords match
    */
    private $conf;
 
    //! A constructor.
    /**
    * Constucts a new ValidatePassword object subclass or Validator
    * @param $pass the string to validate
    * @param $conf to compare with $pass for confirmation
    */
    public function __construct($pass,$conf) {
        $this->pass=$pass;
        $this->conf=$conf;
        Validator::__construct();
    }
 
    //! A manipulator
    /**
    * Validates a password
    * @return void
    */
    public function validate() {
        if ($this->pass!=$this->conf) {
            $this->setError('Passwords do not match');
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/',$this->pass )) {
            $this->setError('Password contains invalid characters');
        }
        if (strlen($this->pass) < 6 ) {
            $this->setError('Password is too short');
        }
        if (strlen($this->pass) > 20 ) {
            $this->setError('Password is too long');
        }
    }
}
 
/**
 *  ValidatorEmail subclass of Validator
 *  Validates an email address
 */
class ValidateEmail extends Validator {
    /**
    * Private
    * $email the email address to validate
    */
    private $email;
 
    //! A constructor.
    /**
    * Constucts a new ValidateEmail object subclass or Validator
    * @param $email the string to validate
    */
    public function __construct($email){
        $this->email=$email;
        Validator::__construct();
    }
 
    //! A manipulator
    /**
    * Validates an email address
    * @return void
    */
    public function validate() {
        $pattern=
    "/^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/";
        if(!preg_match($pattern,$this->email)){
            $this->setError('Invalid email address');
        }
        if (strlen($this->email)>255){
            $this->setError('Address is too long');
        }
    }
}
?>