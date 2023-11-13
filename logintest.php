<?php
include 'libs/load.php';

$user = "took";
$password = "test";
$result = null;

if (isset($_GET['logout'])) {
    Session::destroy();
    die("Session destroyed, <a href='logintest.php'>Login Again</a>");
}

if (Session::get('is_loggedin')) {
    $userdata = Session::get('session_user');
    echo "Welcome Back, " . $userdata['username'];
    //var_dump($userdata);
    $result = $userdata;
} else {
    printf("No session found, trying to login now. <br>");
    $result = User::login($user, $password);
    if ($result) {
        echo "Login Success, " . $result['username'];
        Session::set('is_loggedin', true);
        Session::set('session_user', $result); // Store the user data in session
    } else {
        echo "Login failed <br>";
    }
}

echo <<<EOL
<br><br><a href="logintest.php?logout">Logout</a>
EOL;
?>
