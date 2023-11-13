<?php

 $dockerAPI = new DockerContainerAPI;
 $dockerAPI->container_info();
 $res=null;
 $err=null;

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
                //echo "API Response: " . $response;
                $res=$response;
            } catch (Exception $e) {
               // echo "API Error: " . $e->getMessage();
               $err=$e->getMessage();
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
                //echo "API Response: " . $response;
               $res=$response;
            } catch (Exception $e) {
               // echo "API Error: " . $e->getMessage();
               $err=$e->getMessage();
            }
         }
         if (isset($_COOKIE['coninfo'])) {
            $coninfo = json_decode($_COOKIE['coninfo'], true);
            
            // Access specific values like this:
            $username = $coninfo['username'];
            $containername = $coninfo['containername'];
            $rootpass = $coninfo['rootpass'];
        }
         
            
         

?> 

<div class="test1">
<div class="window"> 
    <?
    
    if (!is_null($res)) {
        $msg=$res;
        
    } 
    if (!is_null($err)) {
        $msg=$res;
        
    }     
    
     //echo $err;echo $res;
  ?>   
    <span class="h2">Welcome!!!</span><br>
    
 

</div></div>
<form method="post">
<div class="test">
<div class="window1">
    <button name="button1" class="custom-btn btn-15">start</button>
    <button name="button2" class="custom-btn btn-11">stop</button>
    <button name="button3" class="custom-btn btn-16">Restart</button><br>
    <span class="h2"><? echo $msg; ?></span>
</div>
<div class="window2">
    <span class="h2">Container Info</span><br>
    <?
     echo "ContainerName:";
     echo '<input type="text" class="mt-2 form-control" readonly="readonly" value="'.$containername.'">';
     echo "UserName:";
     echo '<input type="text" class="mt-2 form-control" readonly="readonly" value="'.$username.'">';
     echo "RootPass:";
     echo '<input type="text" class="mt-2 form-control" readonly="readonly" value="'.$rootpass.'">';
    // echo "Username: " . $username . "<br>";
    // echo "Container Name: " . $containername . "<br>";
    // echo "Root Password: " . $rootpass . "<br>";

    ?>

</div>

</div>
 </form>
