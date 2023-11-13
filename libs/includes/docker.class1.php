<?php
class DockerContainerAPI {
    private $apiUrl;

    public function __construct($apiUrl = 'http://api:5000') {
         $this->apiUrl = $apiUrl;
    }

    public function createContainer($username, $password, $containerName, $apiKey) {
        // Build the query parameters
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

        if (curl_errno($ch)) {
            throw new Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        if ($response === false) {
            throw new Exception('API request failed.');
        }

        return $response;
    }

    public function stopContainer($containerName, $apiKey) {
        // Build the query parameters
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

        return $response;
    }


    public function startContainer($containerName, $apiKey) {
        // Build the query parameters
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

        return $response;
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
