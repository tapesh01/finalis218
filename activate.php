<?php
require('includes/config.php'); //includes properties of config.php

//two variables that gets the x and y values from the db
$memberID = trim($_GET['x']);
$active = trim($_GET['y']);

//if(memberID is numerical and the active variable is not empty) DO:
if(is_numeric($memberID) && !empty($active)){

	//set a variable that updates the db's members and set active to 'Yes'
  //make the stmt execute the db and make the variables equal to ' :memberID' and ':active'
	$stmt = $db->prepare("UPDATE members SET active = 'Yes' WHERE memberID = :memberID AND active = :active");
	$stmt->execute(array(
		':memberID' => $memberID,
		':active' => $active
	));

	//if stmt is updated it should equal 1 so then do :
	if($stmt->rowCount() == 1){

		//redirect to login page
		header('Location: login.php?action=active');
		exit;
    //else just tell the user the accound cant be activated
	} else {
		echo "Your account could not be activated.";
	}

}
?>
