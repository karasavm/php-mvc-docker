<?php

namespace App\Controllers;

use App\Models\Company;
use Core\View;

class Companies extends \Core\Controller {

    public function indexAction() {


        $companies = Company::getAll();

        View::renderTemplate('Companies/index.html', [
            'companies' => $companies
        ]);


    }
}