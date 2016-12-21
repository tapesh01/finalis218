<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('US/Eastern');

//database credentials
define('DBHOST','sql1.njit.edu');
define('DBUSER','tn64');
define('DBPASS','heaven47');
define('DBNAME','tn64');

//application address
define('DIR','http://web.njit.edu/~tn64/final/');
define('SITEEMAIL','tn64@njit.edu');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
