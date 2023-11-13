<?php
// include 'libs/load.php';
$fail=null;
$signup = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Corrected: Get user data from User::login
        $result = User::login($username, $password);

        if ($result) {
            // Redirect to a different page on successful login
            Session::set('is_loggedin', true);
            Session::set('session_user', $result); // Set session_user with user data
            header("Location: manage.php");
            exit();
        } else {
            $fail = "Invalid credentials. Please try again.";
        }
    } 
}
?>




	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1>login</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="login.php" method="post">
				    <input class="text" type="text" name="username" placeholder="Username" required=""><br>
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


	