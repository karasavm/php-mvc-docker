<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * PHP version 5.4
 */
class Company extends \Core\Model
{

    /**
     * Get all the companies as an associative array
     *
     * @return array
     */
    public static function getAll()
    {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT id, name, lat_lon FROM companies');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
