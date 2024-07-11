<?php

namespace App;

use PDO;
use Random\RandomException;

class User
{
    private PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Finds a user by email or creates a new user.
     * @param $email
     * @return array|mixed
     */
    public function findOrCreateUser($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $stmt = $this->pdo->prepare("INSERT INTO users (email, token) VALUES (?, ?) RETURNING id");
            $stmt->execute([$email, Utils::generateToken()]);
            $userId = $stmt->fetchColumn();
            return ['id' => $userId, 'email' => $email];
        }

        return $user;
    }

    /**
     * Gets a user by their ID.
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Updates a user's token.
     * @param $id
     * @param bool $token
     * @return string
     */
    public function updateUserToken($id, $token = false): string
    {
        // Generate a random token if not provided
        if (!$token) {
            $token = Utils::generateToken();
        }
        $stmt = $this->pdo->prepare("UPDATE users SET token = ? WHERE id = ?");
        $stmt->execute([$token, $id]);
        return $token;
    }

    /**
     * Gets a user by their email.
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}