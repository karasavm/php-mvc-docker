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

    /**
     * Display company's page, according to provided id from route_params array.
     *
     * @return void
     */
    public function showAction() {
        $id = $this->route_params['id'];
        $company = Company::getById($id);
        View::renderTemplate('Companies/show.html', [
            'company' => $company
        ]);
    }
}