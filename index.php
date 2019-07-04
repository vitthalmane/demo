<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
header('location: http://localhost:stock/dashboard.php');
}

$errors = array();

if($_POST) {		

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Username is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = ($password);
			// exists
			$mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];

				// set session
				$_SESSION['userId'] = $user_id;

				header("refresh:2; url=dashboard.php");
			} 
			else{
				
				$errors[] = "Incorrect username/password combination";
			} // /else
		} else {		
			$errors[] = "Username doesnot exists";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>
<!DOCTYPE html>
  <html>
    <head>
      <title>Login Page</title>
      <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body style="background:url(assests/images/stock/y.jpg);background-repeat:no-repeat;background-size:100% ,100%">

      <div class="header">
	     <h2>Login Form</h2>
		</div>
		<form method="post" action"<?php echo $_SERVER['PHP_SELF'] ?>">
		<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" required>
		</div>
		
        <div class="input-group">
		<label>Password</label>
		<input type="text" name="password">
		</div>
		
		<div class="input-group">
		<button type="submit" name="login" class="btn"><b>LogIn</b></button>
		<button type="submit" name="login" class="btn"><b>Cancel</b></button>
		</div>
		
		</form>
    </body>
  </html>