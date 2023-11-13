<?
 include 'libs/load.php';

class buttton{
    public function startbutton()
    { 
        if (Session::get('is_loggedin')) {
            $userdata = Session::get('session_user');
            if (isset($userdata['username'])) {
                $userID = $userdata['id'];
                $api = $userdata['api'];
        
            }
        }
        $dockerAPI = new DockerContainerAPI;
        $dockerAPI->container_info();
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
}