<?php
//include config
require_once('includes/config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: index.php'); }

//process login form if submitted
if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$password = $_POST['password'];

//if the db can find the user create a session and imply header and exit session
	if($user->login($username,$password)){
		$_SESSION['username'] = $username;
		header('Location: memberpage.php');
		exit;

	}

//else post error
  else {
		$error[] = 'Wrong username or password or your account has not been activated.';
	}

}//end if submit

//define page title
$title = 'Login';

//include header template
require('layout/header.php');
?>

<!MainHeader div>
<div id="MainHeader">
<center>
	<h1>Tapesh Nagarwal's Website</h1>  <!center header>
</center>
</div>

<div class="container">     <!create container>

	<div class="row">    <!create row>

				<center><h2>Please Login</h2> <!center header>
				<p><a href='./'>Back to home page</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
							break;
					}

				}


				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
				</div>

				<div class="row">

						 <a href='reset.php'>Forgot your Password?</a>
					</div>
				</div>

				<hr>
				<div class="row">
					<center><input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5"></div><center>
				</div>
			</form>
		</div>
	</div>



</div>


<?php
//include header template
require('layout/footer.php');
?>
