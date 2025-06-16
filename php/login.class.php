<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class LoginUser {
    private $username;
    private $password;
    public $error;
    public $success;
    private $storage = "data.json";
    private $stored_user;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;

        // Try to read JSON file
        try {
            if (!file_exists($this->storage)) {
                throw new Exception("User data file not found.");
            }
            $data = file_get_contents($this->storage);
            $this->stored_user = json_decode($data, true) ?? [];

            $this->login();
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    private function login() {
        foreach ($this->stored_user as $user) {
            if ($user['username'] === $this->username) {
                if (password_verify($this->password, $user['password'])) {
                    $_SESSION['user'] = $this->username;
                    
                    // Flush output before redirecting
                    ob_clean();
                    
                    header("Location: gaia.php");
                    exit();
                }
            }
        }

        $this->error = "Wrong username or password";
    }
}
?>
