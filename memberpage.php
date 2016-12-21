<?php
 require('includes/config.php');

//if user is not logged in then send to login.php
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'User Profile';

//include header template
require('layout/header.php');
?>
<!MainHeader div>
<div id="MainHeader">
<center>
	<h1>Tapesh Nagarwal's Website</h1> <!center header title>
</center>
</div>
<div class="container"> <!container div>

	<div class="row">  <!row div>
				<h2>Welcome to the Community: <?php echo $_SESSION['username']; ?></h2>  
				<p><a href='logout.php'>Logout</a></p>
				<hr>

		</div>
	</div>


</div>

<?php
//include header template
require('layout/footer.php');
?>
