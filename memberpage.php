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
<p><a href='logout.php'>Logout</a></p>
<div class="container"> <!container div>

	<div class="row">  <!row div>
    <hr>
			<center><h2>Welcome to the Community: <?php echo $_SESSION['username']; ?></h2></center>

        <center><div class="input-group">
          <?php
            if (isset($_SESSION['userpic'])){
              echo '<img src="'.$_SESSION['userpic'].'" alt="'.$_SESSION['username'].'" />';
            }
           ?>
        </div>
        <center><a href="upload.php"><== Click Here to change your Profile Picture! ==></center>
      </center>
		</div>
	</div>


<?php
//include header template
require('layout/footer.php');
?>
