<?php
namespace App\Controller;

use App\Model\TodoModel;
use App\View\StandardView;
use App\Core\DatabaseHandler;


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
       
            $rankMore = DatabaseHandler::query('SELECT COUNT(*) FROM `todos`');
            $result = $rankMore->fetchAll(); 
            $rank = intval($result[0][0]) + 1;

            $stmt = DatabaseHandler::prepare('
            INSERT INTO `todos`
            (`description`, `done`, `rank`)
            VALUES (:description, :done, :rank)
            ');

            $stmt->execute([
                ':description' => $_POST['description'],
                ':done' => false,
                ':rank' => $rank,

            ]);

                header('location: /todos');
    }

    public function update(int $id)
    {

    }
}
