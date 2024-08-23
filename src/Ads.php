<?php

declare(strict_types=1);

namespace App;

use Exception;
use PDO;

class Ads
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function createAds(
        string $title,
        string $description,
        int    $user_id,
        int    $status_id,
        int    $branch_id,
        string $address,
        float  $price,
        int    $rooms
    ): bool|array|object
    {
            $query = "INSERT INTO ads (title, description, user_id, status_id, branch_id, address, price, rooms, created_at) 
                  VALUES (:title, :description, :user_id, :status_id, :branch_id, :address, :price, :rooms, NOW())";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':status_id', $status_id);
            $stmt->bindParam(':branch_id', $branch_id);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':rooms', $rooms);
            $stmt->execute();

            return $stmt->fetch();
    }


    public function getAd($id)
    {
        $query = "SELECT * FROM ads WHERE id = :id";
        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getAds(): false|array
    {
        $query = "SELECT *, ads.id AS id, ads.address AS address FROM ads JOIN branch ON branch.id = ads.branch_id";
         return $this->pdo->query($query)->fetchAll();
    }

    public function updateAds(
        int    $id,
        string $title,
        string $description,
        int    $user_id,
        int    $status_id,
        int    $branch_id,
        string $address,
        float  $price,
        int    $rooms
    ) {
        $query = "UPDATE ads SET title = :title, description = :description, user_id = :user_id,
                 status_id = :status_id, branch_id = :branch_id, address = :address, 
                 price = :price, rooms = :rooms, updated_at = NOW() WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':status_id', $status_id);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':rooms', $rooms);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveImage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'];
            $profileImage = $_FILES['profile_image'];

            if ($profileImage['error'] === 0) {
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($profileImage["name"]);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                if (move_uploaded_file($profileImage["tmp_name"], $targetFile)) {
                    $stmt = $this->pdo->prepare("INSERT INTO users (user_id, image_path) VALUES (:user_id, :image_path)");
                    $stmt->bindParam(':user_id', $userId);
                    $stmt->bindParam(':image_path', $targetFile);
                    $stmt->execute();

                    echo "Rasm muvaffaqiyatli yuklandi va database-ga saqlandi.";
                } else {
                    echo "Rasm yuklashda xato yuz berdi.";
                }
            } else {
                echo "Rasmni yuklashda xato.";
            }
        }

    }


    public function getAdr(int $id)
    {
        $query = "SELECT 
                ads.id AS id,
                ads.title AS title,
                ads.description AS description,
                ads.price AS price,
                ads.rooms AS rooms,
                ads.address AS address,
                ads.created_at AS created_at,
                branch.name AS branch,
                users.username AS user,
                users.position AS position,
                users.gender AS gender,
                users.phone AS phone,
                status.name AS status_name
              FROM ads
              JOIN branch ON branch.id = ads.branch_id
              JOIN users ON users.id = ads.user_id
              JOIN status ON status.id = ads.status_id
              WHERE ads.id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function deleteAds(int $id): array|false
    {
        $query = "DELETE FROM ads WHERE id = :id";
        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}