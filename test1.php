<?php
 include 'libs/load.php';
 $dockerAPI = new DockerContainerAPI;
 $dockerAPI->container_info();

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

         if(array_key_exists('button2', $_POST)) { 
            if (isset($_COOKIE['coninfo'])) {
                $coninfo = json_decode($_COOKIE['coninfo'], true);
                
                // Access specific values like this:
                $username = $coninfo['username'];
                $containername = $coninfo['containername'];
                $rootpass = $coninfo['rootpass'];
            }
             $conname = $coninfo['containername'];
             
          
            //  Replace with the actual API key
          
            try {
               $response = $dockerAPI->stopContainer($conname, $api);
                echo "API Response: " . $response;
            } catch (Exception $e) {
                echo "API Error: " . $e->getMessage();
            }
         }
         else if(array_key_exists('button1', $_POST)) { 
            if (isset($_COOKIE['coninfo'])) {
                $coninfo = json_decode($_COOKIE['coninfo'], true);
                
                // Access specific values like this:
                $username = $coninfo['username'];
                $containername = $coninfo['containername'];
                $rootpass = $coninfo['rootpass'];
            }
             $conname = $coninfo['containername'];
             
          
            //  Replace with the actual API key
          
            try {
               $response = $dockerAPI->startContainer($conname, $api);
                echo "API Response: " . $response;
            } catch (Exception $e) {
                echo "API Error: " . $e->getMessage();
            }
         }
            
         

?> 
<form method="post">
<div class="test1">
<div class="window">    
    <button name="button1" class="custom-btn btn-15">start</button>
    <button name="button2" class="custom-btn btn-11">stop</button>
    <button name="button3" class="custom-btn btn-16">Restart</button>
</div></div></form>
<div class="test">
<div class="window1"></div>
<div class="window2"></div>
</div>
 
