<?php
include_once 'includes/database.php';
include_once 'includes/functions.php';

class User {
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($id = null, $name = null, $email = null, $password = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = sanitizeInput($name);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = sanitizeInput($email);
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function save() {
        $data = array(
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        );
        if ($this->id === null) {
            $this->id = insert('users', $data);
        } else {
            update('users', $this->id, $data);
        }
    }

    public function delete() {
        if ($this->id !== null) {
            delete('users', $this->id);
            $this->id = null;
        }
    }

    public static function getById($id) {
        $row = fetchById('users', $id);
        if ($row) {
            return new User(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['password']
            );
        }
        return null;
    }

    public static function getByEmail($email) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        if ($row) {
            return new User(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['password']
            );
        }
        return null;
    }

    public function validatePassword($password) {
        return password_verify($password, $this->password);
    }
}
?>
