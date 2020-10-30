<?php

namespace App\Controller;

use App\Model\TodoModel;
use App\Core\AbstractView;
use App\View\StandardView;

class MainController
{
    /**
     * Display home page
     */
    public function home()
    {
        require './pages/home.php';
    }

}
