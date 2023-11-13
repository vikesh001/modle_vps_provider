<?php
require_once "Database.class.php";
class User
{
    private $conn;    // Database connection
    private $username;  // User's username
    private $id;        // User's ID

    public function __construct($username)
    {
        //TODO: Write the code to fetch user data from Database for the given username. If username is not present, throw Exception.

        $this->conn = Database::getConnection();
        $this->username = $username;

        $sql = "SELECT `id` FROM `auth` WHERE `username`= '$username' LIMIT 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->id = $row['id']; //Updating this from database
        } else {
            throw new Exception("Username doesn't exist");
        }
    }


    public static function signup($username, $password, $email)
    {
        $conn = Database::getConnection();
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $api_key = bin2hex(random_bytes(16)); // Generate a random 32-character hexadecimal string
    
        try {
            $sql = "INSERT INTO `signup` (`username`, `email`, `password`, `api`)
                    VALUES (?, ?, ?, ?)";
    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $api_key);
    
            if ($stmt->execute()) {
                return null; // Success, return null to indicate no error
            } else {
                return "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            return "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }
    



    
    public static function login($username, $password)
{
    $conn = Database::getConnection();

    try {
        $sql = "SELECT * FROM signup WHERE username=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    // Password matches, return the user data
                    return $user;
                }
            }
        }

        return false; // User does not exist or password is incorrect
    } catch (mysqli_sql_exception $e) {
        return false; // Handle the error gracefully
    } finally {
        $stmt->close();
        $conn->close();
    }
}


}


