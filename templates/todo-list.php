<!-- todo-list.php-->

<h1>Ma liste de tâches</h1>
        <ul id="todo-list" class="list-group mb-4">

            <?php foreach ($todos as $todo): ?>
            
              <li  class="list-group-item" >
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight"><input type="checkbox">
                        <?php if($todo['done']): ?>
                        <del class="text-muted">
                            <?= $todo['description'] ?>
                        </del>
                        <?php else: ?>
                        <?= $todo['description'] ?>
                        <?php endif; ?>
                    </div>
                    <div class="p-2 bd-highlight">    
                        <form action="" method="post">
                            <input type="hidden" name="<?= $todo['id'] ?>">
                            <button type="button" class="btn btn-warning"><i class="far fa-edit"></i></button>
                        </form>
                    </div>
                 <div class="p-2 bd-highlight">
                        <form action="" method="post">
                            <input type="hidden" name="<?= $todo['id'] ?>">
                            <button type="button" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                 </div>
                </div>
             </li>
            
            <?php endforeach; ?>

        </ul>
        <form method="post" action="/todos/new" id="add-todo" class="d-flex">
            <input id="add-todo-name" name="description" class="form-control" type="text" placeholder="Entrez une nouvelle tâche" />
            <button id="add-todo-button" class="btn btn-success">Ajouter</button>
        </form>