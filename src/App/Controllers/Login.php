<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;
use App\Auth;

class Login extends \Core\Controller {

    /* Show login page

     * @return void
     */
    public function indexAction() {

        View::renderTemplate('Login/index.html', []);
    }

    /*
     * Log in user
     *
     * @return void
     */
    public function createAction() {

        $user = User::authenticate($_POST['email'], $_POST['password']);

        if ($user) {

            Auth::login($user);

            $this->redirect(Auth::getReturnToPage());

        } else {
            View::renderTemplate('Login/index.html', [
                'email' => $_POST['email']
            ]);
        }
    }

    /*
     * Log out a user
     *
     * @return void
     */
    public function destroyAction() {

        Auth::logout();

        $this->redirect('');
    }
}