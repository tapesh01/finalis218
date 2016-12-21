<?php require('includes/config.php');

//if the user variable is logged in : grab the header stuff from memberpage.php
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been set to 'submit', do:
if(isset($_POST['submit'])){

	//if the username string length is less than 3 send error message that its to short
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	}


//else do the following in db:
  else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

//if the username row is not empty send the error message that the username
//is already in use
		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}
//if the password string length is less than 3 then
//send the error message that the password is too short
	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}
//if the confirm password string length is less than 3 then
//send the error message that the confirm passwor is too short
	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}
// if the password and confirm password do not match then send the error message
// that the passwords do not match
	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation that if it is not true send error message that the
  //submitted email is not valid and the user needs to provide a valid one
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	}

//else store the emai on the db
  else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

//if the email row is not empty then send error message that the email is
//already in use
		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}


	//if error is not set:
	if(!isset($error)){

		//hasedpassword variable that makes the password hashed and stores it in the db
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email'],
				':active' => $activasion
			));
			$id = $db->lastInsertId('memberID');

			//send email with the activasion code from above that was made with md5 function
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at tn64's Site!</p>
			<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards -Tapesh</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'tn64 Final Project is218';

//include header template
require('layout/header.php');
?>

<!main header div>
<div id="MainHeader">
<center>
	<h1>Tapesh Nagarwal's Website</h1>    <!sender this header>
</center>
</div>
<div class="container">   <!container div>

	<div class="row">        <!row div>
		<form role="form" method="post" action="" autocomplete="off">   <!form>


        <center><h3>Sign Up Here:</h3></center>   <!center the header>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
				}
				?>


				<center>
				<div class="form-group">  <!create div for username feild>
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>
				<div class="form-group">  <!create div for email feild>
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
				</div>
				<div class="row">   <!create row div for password and confirm password>
						<div class="form-group">  <!create div for password>
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
						</div>
					</div>
						<div class="form-group">  <!create div for confirm password>
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
						</div>
					</div>
				</div>

				<div class="row"> <!create row div for submit button>
          <center><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div><center>
				</div>
			</form>  <! end form>
			<center><p>Already a member? <a href='login.php'>Login</a></p></center>  <!link to login.php if user is already a member>

		</div>
	</div>

</div>

<?php
//include header template
require('layout/footer.php');
?>
