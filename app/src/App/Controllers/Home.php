<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        //echo "(before) ";
        //return false;
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        //echo " (after)";
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        /*
        View::render('Home/index.php', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
        */
        View::renderTemplate('Home/index.html', [
//            'name'    => 'Mike',
            'colours' => ['red', 'green', 'blue']
        ]);
    }

    /**
     * Health check /ping GET api
     *
     * @return void
     */
    public function pingAction() {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "pong"));
    }
}
