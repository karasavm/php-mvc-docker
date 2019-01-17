<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;

class Users extends \Core\Controller {

    public function indexAction() {
        $users = User::getAll();

        View::renderTemplate('Users/index.html', [
            'users' => $users
        ]);

    }

}