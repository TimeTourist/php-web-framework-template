<?php
/**
 *  
 */
class User {
  
  public $id;
  public $name;

  /**
    * Constructor populates members id and name 
    * from the session if there is one
    */  
  public function __construct () {
    if (isset ($_SESSION['userid'])) {
      $this->id = $_SESSION['userid'];
      $this->name = $_SESSION['username'];
    }
  }
  
  /**
    * Authorize user on login, and logs it.
    * @param $user
    * @param $password  
    * @return array $returnMsg 'true' if authorization 
    *         succeded else there is an array of error messages.  
    */
  public function authorize ($username, $password) {
    global $dbh;
    $returnMsg = array();

    /* Validate form, check that they are not empty */
    $isValid = 'true';
    if (empty ($username)) {
      array_push ($returnMsg, 'Du m&aring;ste ange ett anv&auml;ndarnamn.'); 
      $isValid = 'false';      
    }
    if (empty ($password)) {
      array_push ($returnMsg, 'Du m&aring;ste ange ett l&ouml;senord.');
      $isValid = 'false';      
    }
    if ($isValid == 'false') {
      array_push ($returnMsg, 'Var v&auml;nlig och f&ouml;rs&ouml;k igen.');
      return $returnMsg;
    }
    
    /* Authorize user */
    /* Prevent sql injection */
    $sql = sprintf("SELECT * FROM users WHERE username = '%s' LIMIT 1", $dbh->escape_string($username));
    $result = $dbh->query($sql);
    $dbi = new QueryResultIterator($result);
    $object = $dbi->get();
    
    /* Check if the user has tried more than 3 times in a row and failed */
    if ($object->failcount >= 3) {
      array_push ($returnMsg, 'Du &auml; avst&auml;ngd fr&aring;n tj&auml;nsten, var v&auml;nlig kontakta banken.');
      return $returnMsg;
    }
    
    /* Check the password */
    if ($object->password == md5($password)) {
      $_SESSION['userid'] = $object->id;
      $_SESSION['username'] = $username;
      $this->id = $object->id;
      $this->name = $username;
      array_push ($returnMsg, 'true');
      $success = 'true';
    } 
    else {
      array_push ($returnMsg, 'Fel anv&auml;ndarnamn eller l&ouml;senord.');
      $success = 'false';
    }
    
    /* set the failcount in the database */
    if ($success == 'true') {
      $failcount = 0;
    } 
    else {
      $failcount = $object->failcount + 1;
      /* Send a mail to admin */
      if ($failcount >= 3) {
        $from = "From: info@example.com \r\n";
        $to = "magnus@kanelbulle.com";
        $subject = "Possible break in attempt in progress!";
        $body = "This is an automatic mail from the loginpage.\n\nUser $username has failed to login $failcount times.";
        if (mail($to, $subject, $body, $from)) {
          array_push ($returnMsg, 'Ditt konto &auml;r avst&auml;ngt pga f&ouml;r m&aring;nga inloggningsf&ouml;rs&ouml;k.');
        }
      }
    }
    $sql = sprintf("UPDATE users SET failcount = '%s' WHERE username = '%s'", $failcount, $username);
    $dbh->query($sql); 
    
    
    /* Log the login attempt */
    $sessionid = session_id();
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO logins (user_id, success, sessionid, IP) VALUES ('{$object->id}', '$success', '$sessionid', '$ip')";
    $dbh->query($sql);    

    return $returnMsg; 
  }
  
  /**
    * Checks if user is authorized
    * @return $bool true if authorized
    */
  public function isAuthorized () {
    
    /* check if session is set */
    if (empty($_SESSION['userid']) || empty($_SESSION['username'])) {
      return false;
    }
    
    /* Check if the session is valid, i.e, not hijacked. */
    global $dbh;
    $sessionid = session_id();
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "SELECT IP, sessionid FROM logins where user_id = '{$this->id}' AND success = 'true' ORDER BY ts DESC LIMIT 1";
    $result = $dbh->query($sql);
    $dbi = new QueryResultIterator($result);
    $login = $dbi->get();
    if ($login->sessionid == $sessionid && $login->IP == $ip) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
    * Destroy the session
    * @return $bool true
    */  
  public function logout () {
    unset($this->id);
    unset($_SESSION['userid']);
    unset($this->name);    
    unset($_SESSION['username']);
    return true;
  }

  /**
    * Get account information object 
    * @return $bool true if authorized
    */  
  public function getAccountInfo () {
    global $dbh;
    $result = $dbh->query("SELECT * FROM accounts WHERE user_id = '{$this->id}' LIMIT 1");
    $dbi = new QueryResultIterator($result);
    return $dbi->get();
  }

  /**
    * Gets the latest login datetime
    * @return $bool true if authorized
    */
  public function getLatestLogin () {
    global $dbh;
    $result = $dbh->query("SELECT * FROM logins WHERE success = 'true' AND user_id = '{$this->id}' ORDER BY ts ASC LIMIT 2");
    $dbi = new QueryResultIterator($result);
    return $dbi->get();
  } 
}
?>