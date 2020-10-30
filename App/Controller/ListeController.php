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

        $stmt = DatabaseHandler::prepare('SELECT * FROM `todos` WHERE `id`');
        $stmt->execute([':id' => $id]);
        $todo = $stmt->fetchAll()[0];
        
        if (isset($_POST['description'])){
            $todo['description'] = $_POST['description'];
        }

        if (isset($_POST['rank'])){
            $todo['rank'] = $_POST['rank'];
        }

        $stmt = DatabaseHandler::prepare('
        UPDATE `todos`
        SET 
            `description` = :description,
            `rank` = :rank,
            `done` = :done
        WHERE `id` = :id
        ');

        $stmt->execute([
            ':description' => $_POST['description'],
            ':done' =>  $_POST['done'],
            ':rank' =>  $_POST['rank'],
            ':id' => $id

        ]);

        header('location: /todos');

 
    }

    public function delete(int $id)
    {
            $stmt = DatabaseHandler::prepare('DELETE FROM `todos` WHERE `id` = :id');
            $stmt->execute([':id' => $id]);
            header('location: /todos');
    }
}
