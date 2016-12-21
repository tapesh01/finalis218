<!include the config.php attributes>
<?php require('includes/config.php');

//make user variable perform logout function
$user->logout();

//logged out so return to index page and exit
header('Location: index.php');
exit;
?>
