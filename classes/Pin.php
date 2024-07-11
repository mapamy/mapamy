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

}