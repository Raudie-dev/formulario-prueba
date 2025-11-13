<?php
class User extends Model {
    public function register($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $this->insert('users', [
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function login($username, $password) {
        $user = $this->fetch("SELECT * FROM users WHERE username = ?", [$username]);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            return true;
        }
        return false;
    }

    public function getUserById($id) {
        return $this->fetch("SELECT * FROM users WHERE id = ?", [$id]);
    }

    public function usernameExists($username) {
        $result = $this->fetch("SELECT id FROM users WHERE username = ?", [$username]);
        return $result !== false;
    }

    public function emailExists($email) {
        $result = $this->fetch("SELECT id FROM users WHERE email = ?", [$email]);
        return $result !== false;
    }

    public function logout() {
        session_destroy();
    }
}
?>
