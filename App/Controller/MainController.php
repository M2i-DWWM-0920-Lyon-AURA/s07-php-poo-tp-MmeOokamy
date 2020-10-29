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
    public function home(): AbstractView
    {
        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant la page d'accueil
            ['pages/home' ]
        );
    }

}
