<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;
use App\Auth;   

class Profile extends Authenticated {


    /**
     * Show the edit profile page
     * 
     * @return void
     */
    public function editAction() {
        View::renderTemplate('Profile/edit.html', [
            "user" => Auth::getUser()
        ]);
    }

    /**
     * Show the profile page
     * 
     * @return void
     */
    public function showAction() {

        $user = Auth::getUser();


        View::renderTemplate('Profile/show.html',[
            'user' => $user
        ]);
    }

    /**
     * Update the profile
     * 
     * @return void
     */
    public function saveAction() {
        $user = Auth::getUser();
        
        if ($user->update($_POST)) {
            $this->redirect('profile/show');
        } else {
            View::renderTemplate('Profile/edit.html', [
                'user' => $user
            ]);
        }
        
    }
}
