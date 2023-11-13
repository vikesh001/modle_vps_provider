
 <?


if (Session::get('is_loggedin')) {
    $userdata = Session::get('session_user');
    if (isset($userdata['username'])) {
        $user = $userdata['username'];
        $api = $userdata['api'];
        echo "Welcome, " . $api;
    }
}
else {
    header('Location: login.php');
    exit();
}
if(isset($_COOKIE['coninfo'])){
  header('Location: test1.php');
  exit();

}
if (isset($_POST['conname']) and isset($_POST['usrname']) and isset($_POST['rootpass'])  ) {
  $usrname = $_POST['usrname'];
  $rootpass = $_POST['rootpass'];
  $conname = $_POST['conname'];
  $dockerAPI = new DockerContainerAPI;

  // Replace with the actual API key


 try {
    $response = $dockerAPI->createContainer($usrname, $rootpass, $conname, $api);
     echo "API Response: " . $response;
 } catch (Exception $e) {
     echo "API Error: " . $e->getMessage();
 }
}
?>  

<div class="window">
  <span class="h2">Welcome!!!</span>
  <span class="h2">Create Container</span>
  
  <form method="POST"> 
    <input type="text" class="mt-4 form-control" placeholder="Container Name" name="conname">
     <?
     echo '<input type="text" class="mt-2 form-control" placeholder="username" name="usrname" value="'.$user.'">';
  
    ?>
    <input type="password" class="mt-2 form-control"  placeholder="Root password" name="rootpass">
   
   
    <input type="submit" class="mb-2 btn btn-light mt-2" value="Create">
  </form>
</div>
