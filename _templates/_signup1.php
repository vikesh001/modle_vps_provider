<?
include 'load.php';
$signup = false;
if (isset($_POST['Username']) and isset($_POST['password']) and isset($_POST['email']) ) {
    $username = $_POST['Username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $result = signup($username, $password, $email);
}


?>

	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1> SignUp </h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="signup.php" method="post">
					<input class="text" type="text" name="Username" placeholder="Username" required="">
					<input class="text email" type="email" name="email" placeholder="Email" required="">
					<input class="text" type="password" name="password" placeholder="Password" required="">
					<div class="wthree-text">
						<div class="clear"> </div>
					</div>
					<input type="submit" value="SIGNUP">
				</form>
				<p>Don't have an Account? <a href="login.php"> Login Now!</a></p>
			</div>
		</div>
		<!-- //copyright -->
		
	</div>
	<!-- //main -->
