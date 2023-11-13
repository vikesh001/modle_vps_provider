
<?
include 'load.php';

$signup = false;
if (isset($_POST['email']) and isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (User::login($email, $password)) {
        // Redirect to a different page on successful login
        Session::set('is_loggedin',true);
		header("Location: test.php");
        exit();
    } else {
        $fail= "Invalid credentials. Please try again.";
		
    }
}


?>



	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1>login</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="login.php" method="post">
					<input class="text email" type="email" name="email" placeholder="Email" required="">
					<input class="text" type="password" name="password" placeholder="Password" required="">
				
					<input type="submit" value="Login">
					<?print($fail);?>
				</form>
				<p>Don't have an Account? <a href="signup.php"> Signup Now!</a></p>
			</div>
		</div>
		<!-- //copyright -->
		
	</div>
	<!-- //main -->

	