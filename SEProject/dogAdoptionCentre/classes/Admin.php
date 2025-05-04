<?php

class Admin
{
    private $db;
    private $id;
    private $email;
    private $password;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }

    // Setters
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }
    public function setId($id) { $this->id = $id; }

    // Create new admin
    public function create()
    {
        $query = "INSERT INTO admin (email, password) VALUES (:email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password); // hashed already
        return $stmt->execute();
    }

    // Authenticate admin
    public function authenticate($email, $passwordInput)
    {
        $query = "SELECT * FROM admin WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($passwordInput, $admin['password'])) {
            return $admin;
        }

        return false;
    }

    // Get all admins
    public function readAll()
    {
        $query = "SELECT * FROM admin ORDER BY id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get admin by ID
    public function readOne($id)
    {
        $query = "SELECT * FROM admin WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update admin (must call setId(), setEmail(), setPassword() first)
    public function update()
    {
        $query = "UPDATE admin SET email = :email, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password); // must be hashed
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Delete admin by ID
    public function delete($id)
    {
        $query = "DELETE FROM admin WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
