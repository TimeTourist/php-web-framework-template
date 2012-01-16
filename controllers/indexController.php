<?php
/**
 * Default controller class
 */
class index {
  public function __construct () {
  }
  
  function __call() {
    $statusMsg = array();
    $statusMsg = ('sorry!');
    $tmpl = new Template();
    $tmpl->add ('messages', $statusMsg);
    $tmpl->show ('login');
  }
  
  /**
   * Default action.
   */
  public function login () {
    // the global database handler
    global $dbh;
    global $user;
    $statusMsg = array();
    // check if logged in
    if (isset ($_POST['login'])) {
      $statusMsg = $user->login($_POST['username'], $_POST['password']);  
      if ($statusMsg[0] == 'true') {
        /* Redirect to a different page in the current directory that was requested */
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim (dirname ($_SERVER['PHP_SELF']), '/\\');
        $extra = 'index.php?c=index&a=account';
        header ("Location: http://$host$uri/$extra");
        exit();
      }
    } 
    
    $tmpl = new Template();
    $tmpl->add ('messages', $statusMsg);
    $tmpl->show ('login');
  }
  
  /**
   * Contoller for account
   */  
  public function account () {
    /* the global database handler */
    global $user;    
    $account = $user->getAccountInfo();
    $login = $user->getLatestLogin();
    
    $tmpl = new Template();
    $tmpl->add ('account', $account->name);
    $tmpl->add ('balance', $account->balance);
    $tmpl->add ('currency', $account->currency);
    $tmpl->add ('time', $login->ts);
    $tmpl->add ('name', $user->name);
    $tmpl->show ('logedin');
  }
  
  /**
  * 
  */    
  public function logout () {
    // the global database handler
    global $user; 
    $user->logout();
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim (dirname ($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';
    header("Location: http://$host$uri/$extra");
  }
}
?>