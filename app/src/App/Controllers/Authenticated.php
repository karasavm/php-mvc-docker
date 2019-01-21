<?php

namespace App\Controllers;


class Authenticated extends \Core\Controller {


    /**
     * Execute operations before every Controller's action, [requireLogin()]
     *
     * @return void
     */
    public function before() {
        $this->requireLogin();
    }
}