<?php
namespace App\Controller;

use App\Model\TodoModel;
use App\Core\AbstractView;
use App\View\StandardView;

class ListeController
{
    /**
     * Display home page
     */
    public function list()
    {
        require './pages/todo.php';
    }
}
