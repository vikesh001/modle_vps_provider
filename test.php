<?
include 'libs/load.php';
$conn = Database::getConnection();

if (Session::get('is_loggedin')) {
    $userdata = Session::get('session_user');
    if (isset($userdata['username'])) {
        $userID = $userdata['id'];
        $api = $userdata['api'];

    }
}else {
    header('Location: login.php');
    exit();
}

$query = "SELECT username, containername, rootpass FROM info WHERE id = $userID";
$result = mysqli_query($conn, $query); // Use $conn here instead of $mysql

if ($row = mysqli_fetch_assoc($result)) {
    // Store all user information in a single cookie as JSON
    $userData = json_encode($row);
    setcookie('userdata', $userData, time() + 3600, '/');
}

// You don't need to close the database connection explicitly when using the connection from a connection pool like this.

?>

<!DOCTYPE html>
<html>
<head>
    <title>connect.php</title>
</head>
<body>
    <?php
    // Retrieve and decode the user information from the cookie
    if (isset($_COOKIE['userdata'])) {
        $userData = json_decode($_COOKIE['userdata'], true);
        
        // Access specific values like this:
        $username = $userData['username'];
        $containername = $userData['containername'];
        $rootpass = $userData['rootpass'];
        
        // Now you have all the user information in separate variables
        echo "Username: " . $username . "<br>";
        echo "Container Name: " . $containername . "<br>";
        echo "Root Password: " . $rootpass . "<br>";
    } else {
        echo "Cookie not found or data could not be decoded.";
    }
    ?>
</body>
</html>
