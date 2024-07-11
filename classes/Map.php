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
     * Creates a new map.
     * @param int $userId
     * @param string $name
     * @param string $wysiwyg
     * @param int $privacy
     * @return bool
     * @throws Exception
     */
    public function createMap(int $userId, string $name, string $wysiwyg, int $privacy = 1): bool
    {
        $slug = Utils::generateSlug($name);
        $description = Utils::generateExcerpt($wysiwyg);
        $wysiwyg = '<h2>Welcome to my awesome map!</h2><p>' . $description . '</p>';
        $stmt = $this->pdo->prepare('INSERT INTO maps (user_id, name, description, wysiwyg, slug, privacy) VALUES (?, ?, ?, ?, ?, ?) RETURNING id');
        $stmt->execute([$userId, $name, $description, $wysiwyg, $slug, $privacy]);
        $mapId = $stmt->fetchColumn();
        if (!$mapId) {
            throw new Exception('Failed to create map');
        }
        return $mapId;
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

}