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

//        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT id, name, lat_lon FROM companies');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
//        } catch (PDOException $e) {
//            echo $e->getMessage();
//        }
    }

    /**
     * Find a company model by id
     *
     * @param integer $id company's id
     *
     * @return mixed Company object if found, false otherwise
     */
    public static function getById($id)
    {

//        try {
            $db = static::getDB();

            $sql = 'SELECT id, name, lat_lon FROM companies WHERE id=:id';
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetch();


//        } catch (\PDOException $e) {
//            echo 'dddddddddddddddd';
//            echo $e->getMessage();
//        }
    }
}
