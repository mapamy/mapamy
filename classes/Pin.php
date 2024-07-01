<?php

namespace App;

class Pin
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createPin(int $mapId, string $name, string $description, float $latitude, float $longitude): bool
    {
        $slug = Utils::generateSlug($name);
        $stmt = $this->pdo->prepare('INSERT INTO pins (map_id, name, description, slug, location) VALUES (?, ?, ?, ?, ST_MakePoint(?, ?))');
        return $stmt->execute([$mapId, $name, $description, $slug, $longitude, $latitude]);
    }

    public function getPinsByMapId(int $mapId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, map_id, name, description, slug, ST_X(location::geometry) AS longitude, ST_Y(location::geometry) AS latitude FROM pins WHERE map_id = ?');
        $stmt->execute([$mapId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Add more methods as needed
}