<?php
require('includes/config.php');

//if user is not logged in then send to login.php
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Upload Page';

//include header template
require('layout/header.php');
?>

<!MainHeader div>
<div id="MainHeader">
<center>
 <h1>Tapesh Nagarwal's Website</h1> <!center header title>
</center>
</div>
<a href='memberpage.php'>Home</a>
<a href='logout.php'>Logout</a>
<center><h1>Upload Your Profile Pic Below:</h1></center>

<div class="inputgroup">

<center><form action="uploadselector.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <?php
  //  $profile_photo_path="../imgs/users";
  // $count=$dbo->prepare("SELECT userpic from mem_signup where !issetuserpic ");
      if (isset($_SESSION['userpic'])){
        echo '<img src="'.$_SESSION['userpic'].'" alt="'.$_SESSION['username'].'" />';
      }

     ?>
    <input type="file" name="image">
    <input type="submit" value="Upload Image" name="submit">
</form></center>





</div>
<?php
//include header template
require('layout/footer.php');
?>
