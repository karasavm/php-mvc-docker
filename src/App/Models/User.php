<?php

namespace App\Models;

use PDO;
class User extends \Core\Model {


    public static function getAll() {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT id, name, company_id FROM users');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}