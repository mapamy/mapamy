<?php

namespace App;

use Exception;

class Map
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Gets a map by its ID.
     * @param int $id
     * @return array|null
     */
    public function getMapById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM maps WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    /**
     * Gets a list of random maps.
     * @param int $amount
     * @return array
     */
    public function getRandomMaps(int $amount = 10): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM maps ORDER BY RANDOM() LIMIT ?');
        $stmt->execute([$amount]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Updates a map.
     * @param string $slug
     * @return array|null
     */
    public function getMapBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM maps WHERE slug = ?');
        $stmt->execute([$slug]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    /**
     * Gets all maps.
     * @param string $slug
     * @return array|null
     */
    public function getMapByPinSlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT maps.* FROM maps JOIN pins ON maps.id = pins.map_id WHERE pins.slug = ?');
        $stmt->execute([$slug]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    /**
     * Gets a map by a pin ID.
     * @param int $id
     * @return array|null
     */
    public function getMapByPinId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT maps.* FROM maps JOIN pins ON maps.id = pins.map_id WHERE pins.id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    /**
     * Gets all maps by a user ID.
     * @param int $userId
     * @return array
     */
    public function getMapsByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM maps WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new map.
     * @param int $userId
     * @param string $name
     * @param string $description
     * @param int $privacy
     * @return int
     * @throws Exception
     */
    public function createMap(int $userId, string $name, string $description, int $privacy = 1): int
    {
        $slug = Utils::generateSlug($name);
        $description = strip_tags($description);
        $wysiwyg = '<h2>Welcome to my awesome map!</h2><p>' . $description . '</p>';
        $stmt = $this->pdo->prepare('INSERT INTO maps (user_id, name, description, wysiwyg, slug, privacy) VALUES (?, ?, ?, ?, ?, ?)');
        $success = $stmt->execute([$userId, $name, $description, $wysiwyg, $slug, $privacy]);
        if (!$success) {
            throw new Exception('Failed to create map');
        }
        return $this->pdo->lastInsertId();
    }

    /**
     * Updates a map.
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param string $description
     * @param string $wysiwyg
     * @param int $privacy
     * @return void
     */
    public function updateMap(int $id, string $name, string $slug, string $description, string $wysiwyg, int $privacy): void
    {
        $stmt = $this->pdo->prepare('UPDATE maps SET name = ?, slug = ?, description = ?, wysiwyg = ?, privacy = ? WHERE id = ?');
        $stmt->execute([$name, $slug, $description, $wysiwyg, $privacy, $id]);
    }

}