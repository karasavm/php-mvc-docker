<?php

namespace App\Models;

use PDO;

class User extends \Core\Model {

    public $name;
    public $email;
    public $password;
    public $password_hash;
    public $password_confirm;

    public $errors = [];

    public function __construct($name, $email, $password, $password_confirm)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirm = $password_confirm;

    }

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

    /**
     * Save the user with the current property values
     *
     * @return boolean True if user was saved, false otherwise
     */

    public function save() {

        // validate
        $this->validate();

        if (!empty($this->errors)) return false;

        // sql operations
        $sql = 'INSERT INTO users (name, email, password_hash) values (:name, :email, :password)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Update the user is db with the current property values
     *
     * @return boolean True if user was updated, false otherwise
     */
    public function update($data) {
        
        $this->name = $data['name'];
        $this->email = $data['email'];

        if ($data['password'] != '') {
            $this->password = $data['password'];
            $this->password_confirm = $data['password_confirm'];
        }

        // validate
        $this->validate();  //todo: uncomment

        if (!empty($this->errors)) return false;

        // SQL operations
        $sql = 'UPDATE users SET name = :name, email=:email';
        
        // Add password if it is set
        if (isset($this->password)) {
            $sql .= ', password_hash=:password';
        }

        $sql .= ' WHERE id = :id;';

        // execut
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);

        // Add password if it is set
        if (isset($this->password)) {
            $password = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        }
        

        return $stmt->execute();
    }

    /**
     * Validate current user's values
     * @return boolean
     */

    public function validate() {

        // Name
        if ($this->name == '') {
            $this->errors[] = 'Name is required';
        }

        // Email
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) == false) {
            $this->errors[] = 'Invalid email';
        }
        
        if ($this->emailExists($this->email, $this->id ?? null)) {
            $this->errors[] = 'Email already taken';
        }

        // Password
        if (isset($this->password)) {
        
            if ($this->password != $this->password_confirm) {
                $this->errors[] = 'Password must match confirmation';
            }
    
           if (strlen($this->password) < 1) { // todo: chage 1 to 6
               $this->errors[] = 'Please enter at least 6 characters for the password';
           }
        }

//
//        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
//            $this->errors[] = 'Password needs at least one letter';
//        }
//
//        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
//            $this->errors[] = 'Password needs at least one number';
//        }

    }

    /**
     * See if a user already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email, $ignore_id = null) {

        $user = static::findByEmail($email);

        if ($user) {
            if ($user->id != $ignore_id) {
                return true;
            }
        }

        return false;

    }

    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email) {

        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Find a user model by id
     *
     * @param integer $id user's id
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findById($id) {

        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /*
     * Authenticate user by email and password
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed The user object of false if authentication fails
     */
    public static function authenticate($email, $password) {

        $user = static::findByEmail($email);

        if ($user) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }

        return false;
    }
}