<?php

$databaseHandler = new PDO('mysql:host=localhost;dbname=php-todos', 'root', 'root');
$statement = $databaseHandler->query('SELECT * FROM `todos` ORDER BY `rank`');
$todos = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Fontawesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Ma liste de tâches</h1>
        <ul id="todo-list" class="list-group mb-4">

            <?php foreach ($todos as $todo): ?>
            <li class="list-group-item">

                <?php if($todo['done']): ?>
                    <del class="text-muted">
                        <?= $todo['description'] ?>
                    </del>
                <?php else: ?>
                    <?= $todo['description'] ?>
                <?php endif; ?>

            </li>
            <?php endforeach; ?>

        </ul>
        <form id="add-todo" class="d-flex">
            <input id="add-todo-name" name="" class="form-control" type="text" placeholder="Entrez une nouvelle tâche" />
            <button id="add-todo-button" class="btn btn-success">Ajouter</button>
        </form>
    </div>
</body>
</html>