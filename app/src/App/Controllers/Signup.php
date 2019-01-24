<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;

class Signup extends \Core\Controller {



    public function indexAction() {

        View::renderTemplate('Signup/index.html', []);
    }

    public function createAction() {
//        var_dump($_POST);
        
        $user = new User($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirm']);

        if ($user->save()) {

            $this->redirect('signup/success');

        } else {
            View::renderTemplate('Signup/index.html', [
                'user' => $user
            ]);
        }

    }

    public function successAction() {
        View::renderTemplate('Signup/success.html', []);
    }


}