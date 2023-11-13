<?php
require_once "Database.class.php";
class DockerContainerAPI {
    private $apiUrl;

    public function __construct($apiUrl = 'https://generous-intent-opossum.ngrok-free.app') {
         $this->apiUrl = $apiUrl;
    }

    public function createContainer($username, $password, $containerName, $apiKey) {
        // Build the query parameters
        $conn = Database::getConnection(); 
    $id=null;
    // Prepare and execute the first SQL query
    $stmt = $conn->prepare("SELECT id FROM signup WHERE api = ?");
    $stmt->bind_param("s", $apiKey);
    $stmt->execute();
    $stmt->store_result();

    // Check if a record with the specified API value exists
    if ($stmt->num_rows > 0) {
        // Record exists, fetch the ID
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close(); // Close the first statement

        // Prepare and execute the second SQL query using the retrieved ID in the 'info' table
        $stmt = $conn->prepare("SELECT id FROM info WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();

        // Check if a record with the specified ID exists in the 'info' table
        if ($stmt->num_rows > 0) {
            echo "you can create only one container";
        } else {
            $queryParameters = http_build_query([
                'api_key' => $apiKey,
                'username' => $username,
                'password' => $password,
                'containername' => $containerName
            ]);
    
            $url = $this->apiUrl . '/create_container?' . $queryParameters;
    
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            $response = curl_exec($ch);
            $responseData = json_decode($response, true);
            $sql = "INSERT INTO `info` (`id`, `username`, `containername`, `rootpass`,  `containerid`)
            VALUES (?, ?, ?, ?,?)";

            // $stmt = $conn->prepare($sql);
            // $stmt->bind_param("sssss", $id, $responseData['username'], $responseData['containername'], $responseData['rootpass'],$responseData['containerid']);
            // $msg=$responseData['message'] ;
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issss", $id, $responseData['username'], $responseData['containername'], $responseData['rootpass'], $responseData['containerid']);
            $msg = $responseData['message'];
            $stmt->execute();
            $user1=$responseData['username'];
            $con=$responseData['containername'];
            $root=$responseData['rootpass'];
            $conid=$responseData['containerid'];
            $stmt->close();
            $conn->close();

    
            if (curl_errno($ch)) {
                throw new Exception('cURL error: ' . curl_error($ch));
            }
    
            curl_close($ch);
    
            if ($response === false) {
                throw new Exception('API request failed.');
            }
            //echo $id . ' ' . $user1 . ' ' . $con . ' ' . $root . ' ' . $conid;

            return $msg;
        }
    } else {
        echo "user does not exist";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    }

    public function stopContainer($containerName, $apiKey) {
        // Build the query parameters
        $conn = Database::getConnection();
        $id=null;
        // Prepare and execute the first SQL query
        $stmt = $conn->prepare("SELECT id FROM signup WHERE api = ?");
        $stmt->bind_param("s", $apiKey);
        $stmt->execute();
        $stmt->store_result();
    
        // Check if a record with the specified API value exists
        if ($stmt->num_rows > 0) {
            // Record exists, fetch the ID
            $queryParameters = http_build_query([
                'api_key' => $apiKey,
                'containername' => $containerName
            ]);
    
            $url = $this->apiUrl . '/stop_container?' . $queryParameters;
    
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            $response = curl_exec($ch);
            
    
            if (curl_errno($ch)) {
                throw new Exception('cURL error: ' . curl_error($ch));
            }
    
            curl_close($ch);
    
            if ($response === false) {
                throw new Exception('API request failed.');
            }
            $responseData = json_decode($response, true);
            return $responseData['message'];
        } else {
            echo "user does not exist";
        }
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }


    public function startContainer($containerName, $apiKey) {
        // Build the query parameters
        $conn = Database::getConnection();
        $id=null;
        // Prepare and execute the first SQL query
        $stmt = $conn->prepare("SELECT id FROM signup WHERE api = ?");
        $stmt->bind_param("s", $apiKey);
        $stmt->execute();
        $stmt->store_result();
    
        // Check if a record with the specified API value exists
        if ($stmt->num_rows > 0) {
            // Record exists, fetch the ID
            $queryParameters = http_build_query([
                'api_key' => $apiKey,
                'containername' => $containerName
            ]);
    
            $url = $this->apiUrl . '/start_container?' . $queryParameters;
    
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            $response = curl_exec($ch);
    
            if (curl_errno($ch)) {
                throw new Exception('cURL error: ' . curl_error($ch));
            }
    
            curl_close($ch);
    
            if ($response === false) {
                throw new Exception('API request failed.');
            }
    
            $responseData = json_decode($response, true);
            return $responseData['message'];
        } else {
            echo "user does not exist";
        }
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    
    public function container_info() {
        $conn = Database::getConnection();

        if (Session::get('is_loggedin')) {
            $userdata = Session::get('session_user');
            if (isset($userdata['username'])) {
                $userID = $userdata['id'];

                $query = "SELECT username, containername, rootpass FROM info WHERE id = $userID";
                $result = mysqli_query($conn, $query);

                if ($row = mysqli_fetch_assoc($result)) {
                    $userData = json_encode($row);
                    setcookie('coninfo', $userData, time() + 3600, '/');
                }
            }
        }
    }

}

// Example usage:
?>
