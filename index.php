<?php
/* start session */
session_start();

/* configuration */
require('config.php');

/* Include database handling */
require('lib/QueryResultIterator.php');

/* Include Template class */
require('lib/Template.php');

/* Create a global database handler */
// todo, fixa funktion
$dbh = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);
/* check connection */
if ($dbh->connect_errno) {
    printf ("Could not enter site: Database error: %s\n", $dbh->connect_error);
    exit();
} 

/* Create a global user object. */
require('classes/User.php');
$user = new User();


/* Get Controller */
if (isset ($_GET['c']) && $user->isAuthorized()) {
  $controller = $_GET['c'];
} else {
  /*default */
  $controller = "index";
}

/* Get Action */
if (isset ($_GET['a']) && $user->isAuthorized()) {
  $action = $_GET['a'];
} else {
  /* default */
  $action = "login";
}

/* Include the controller */
require ('controllers' . DIRECTORY_SEPARATOR . $controller . 'Controller.php');

/* Create instance of the controller */
$controll = new $controller();


/* Do action */
$controll->$action();


?>