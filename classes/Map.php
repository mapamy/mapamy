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
     * @throws Exception
     */
    public function createMap(int $userId, string $name, string $description, int $privacy = 1): bool
    {
        $slug = Utils::generateSlug($name);
        $stmt = $this->pdo->prepare('INSERT INTO maps (user_id, name, description, slug, privacy) VALUES (?, ?, ?, ?, ?) RETURNING id');
        $stmt->execute([$userId, $name, $description, $slug, $privacy]);
        $mapId = $stmt->fetchColumn();
        if (!$mapId) {
            throw new Exception('Failed to create map');
        }
        return $mapId;
    }

    public function getMapBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM maps WHERE slug = ?');
        $stmt->execute([$slug]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    public function getMapById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM maps WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    // Add more methods as needed
}