<?php

namespace App;

class Pin
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Gets a pin by its ID.
     * @param int $id
     * @return array|null
     */
    public function getPinById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, map_id, name, description, wysiwyg, slug, ST_X(location::geometry) AS longitude, ST_Y(location::geometry) AS latitude FROM pins WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Gets all pins for a map.
     * @param int $mapId
     * @return array
     */
    public function getPinsByMapId(int $mapId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, map_id, name, description, slug, ST_X(location::geometry) AS longitude, ST_Y(location::geometry) AS latitude FROM pins WHERE map_id = ?');
        $stmt->execute([$mapId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Gets a pin by its slug.
     * @param string $slug
     * @return array|null
     */
    public function getPinBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, map_id, name, description, wysiwyg, slug, ST_X(location::geometry) AS longitude, ST_Y(location::geometry) AS latitude FROM pins WHERE slug = ?');
        $stmt->execute([$slug]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Gets all pins for a user.
     * @param int $userId
     * @return array
     */
    public function getPinsByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, map_id, name, description, slug, ST_X(location::geometry) AS longitude, ST_Y(location::geometry) AS latitude FROM pins WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new pin.
     * @param int $mapId
     * @param int $userId
     * @param string $name
     * @param string $wysiwyg
     * @param float $latitude
     * @param float $longitude
     * @return bool
     */
    public function createPin(int $mapId, int $userId, string $name, string $wysiwyg, float $latitude, float $longitude): bool
    {
        $slug = Utils::generateSlug($name);
        $description = Utils::generateExcerpt($wysiwyg);
        $stmt = $this->pdo->prepare('INSERT INTO pins (map_id, user_id, name, description, wysiwyg, slug, location) VALUES (?, ?, ?, ?, ?, ?, ST_MakePoint(?, ?))');
        return $stmt->execute([$mapId, $userId, $name, $description, $wysiwyg, $slug, $longitude, $latitude]);
    }

    /**
     * Updates a pin.
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param string $description
     * @param string $wysiwyg
     * @param float $latitude
     * @param float $longitude
     * @return bool
     */
    public function updatePin(int $id, string $name, string $slug, string $description, string $wysiwyg, float $latitude, float $longitude): bool
    {
        // Check if slug is already in use
        $stmt = $this->pdo->prepare('SELECT id FROM pins WHERE slug = ? AND id != ?');
        $stmt->execute([$slug, $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result !== false) {
            $slug .= '-' . uniqid();
        }
        // Update the pin
        $stmt = $this->pdo->prepare('UPDATE pins SET name = ?, slug = ?, description = ?, wysiwyg = ?, location = ST_MakePoint(?, ?) WHERE id = ?');
        return $stmt->execute([$name, $slug, $description, $wysiwyg, $longitude, $latitude, $id]);
    }

}