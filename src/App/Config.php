<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 5.4
 */
class Config
{

    public function load() {


        # load dot environment's variables
        # todo: check according to .env.example
        $dotenv = \Dotenv\Dotenv::create(dirname(__DIR__));
        $dotenv->load();
//        $dotenv->required(self::REQUIRED);

        # DB
        self::$DB_HOST = getenv('DB_HOST');
        self::$DB_NAME = getenv('DB_NAME');
        self::$DB_USER = getenv('DB_USER');
        self::$DB_PASSWORD = getenv('DB_PASSWORD');

        # Errors
        self::$SHOW_ERRORS = getenv('SHOW_ERRORS');

    }

//    const REQUIRED = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
    /**
     * Database host
     * @var string
     */
    static $DB_HOST;

    /**
     * Database name
     * @var string
     */
    static $DB_NAME;

    /**
     * Database user
     * @var string
     */
    static $DB_USER;

    /**
     * Database password
     * @var string
     */
    static $DB_PASSWORD;

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    static $SHOW_ERRORS;


}
