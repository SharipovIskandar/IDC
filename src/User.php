<?php

declare(strict_types=1);

namespace App;

use PDO;

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function createUser(
        string $username,
        string $position,
        string $gender,
        string $email,
        string $password,
        string $phone
    ): false|array {
        $query = "INSERT INTO users (username, position, gender, email, phone, password, created_at)
                  VALUES (:username, :position, :gender, :email, :phone, :password, NOW())";
        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUser(string $email, string $password)
    {
        $sql = "SELECT
        u.*,
        ur.role_id
        FROM
        users u
        LEFT JOIN
        user_roles ur ON u.id = ur.user_id
        where email = :email;
";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password == $user['password']) {
            return $user['role_id'];
        } else {
            return false;
        }

    }
    public function getUser(int $id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser(
        int    $id,
        string $username,
        string $position,
        string $gender,
        string $phone
    ): void {
        $query = "UPDATE users SET username = :username, position = :position, gender = :gender, phone = :phone, updated_at = NOW()
                  WHERE id = :id";
        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
    }

    public function deleteUser(int $id): void
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
