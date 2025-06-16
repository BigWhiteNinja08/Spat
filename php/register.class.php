<?php
class RegisterUser {
    private $username;
    private $raw_password;
    private $encrypted_password;
    public $error;
    public $success;
    private $storage = "data.json";
    private $stored_users = [];
    private $new_user;

    public function __construct($username, $password) {
        session_start(); // Ensure session is started before redirection

        // Sanitize and trim input
        $this->username = filter_var(trim($username), FILTER_SANITIZE_STRING);
        $this->raw_password = filter_var(trim($password), FILTER_SANITIZE_STRING);
        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        // Load existing users or initialize as empty array
        if (file_exists($this->storage)) {
            $jsonData = file_get_contents($this->storage);
            $this->stored_users = json_decode($jsonData, true) ?? [];
        }

        // Prepare new user data
        $this->new_user = [
            "username" => $this->username,
            "password" => $this->encrypted_password,
        ];

        // Validate inputs and register user
        if ($this->checkFieldValues()) {
            $this->insertUser();
        }
    }

    private function checkFieldValues() {
        if (empty($this->username) || empty($this->raw_password)) {
            $this->error = "Izpolni vsa polja"; // "Fill in all fields"
            return false;
        }
        return true;
    }

    private function usernameExists() {
        foreach ($this->stored_users as $user) {
            if ($this->username == $user['username']) {
                $this->error = "Uporabniško ime je že zasedeno."; // "Username already taken"
                return true;
            }
        }
        return false;
    }

    private function insertUser() {
        if (!$this->usernameExists()) {
            array_push($this->stored_users, $this->new_user);

            try {
                if (file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))) {
                    $_SESSION['user'] = $this->username;
                    $this->success = "Uspešno ste registrirani!"; // "You have successfully registered"
                    
                    // Redirect to login page after registration
                    header("Location: Prijava.php");
                    exit();
                } else {
                    $this->error = "Napaka pri shranjevanju uporabnika."; // "Error saving user"
                }
            } catch (Exception $e) {
                $this->error = "Napaka: " . $e->getMessage(); // "Error: ..."
            }
        }
    }
}
?>
