<?php

namespace App;

class Pin
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createPin(int $mapId, int $userId, string $name, string $wysiwyg, float $latitude, float $longitude): bool
    {
        $slug = Utils::generateSlug($name);
        $description = Utils::generateExcerpt($wysiwyg);
        $stmt = $this->pdo->prepare('INSERT INTO pins (map_id, user_id, name, description, wysiwyg, slug, location) VALUES (?, ?, ?, ?, ?, ?, ST_MakePoint(?, ?))');
        return $stmt->execute([$mapId, $userId, $name, $description, $wysiwyg, $slug, $longitude, $latitude]);
    }

    public function getPinsByMapId(int $mapId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, map_id, name, description, slug, ST_X(location::geometry) AS longitude, ST_Y(location::geometry) AS latitude FROM pins WHERE map_id = ?');
        $stmt->execute([$mapId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}