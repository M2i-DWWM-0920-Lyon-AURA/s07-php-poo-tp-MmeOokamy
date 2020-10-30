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
        $todos = TodoModel::fetchAll();

        require './templates/head.php';
        require './templates/todo-list.php';
        require './templates/footer.php';
    }

    public function create()
    {
        require './templates/head.php';
        echo 'hellow';
        require './templates/footer.php';
    }
}
