<!-- todo-list.php-->

<h1>Ma liste de tâches</h1>
        <ul id="todo-list" class="list-group mb-4">

            <?php foreach ($todos as $todo): ?>
            
              <li  class="list-group-item" >
              <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight" style="flex-grow: 2">
                        <form method="post" action="/todos/<?= $todo['id'] ?>/update" >

                            <input  type="text" name="description" value="<?= $todo['description'] ?>">
                    </div>
                    <div class="p-2 bd-highlight">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                    <div class="p-2 bd-highlight">
                        <form action="/todos/<?= $todo['id'] ?>/delete" method="post">
                    
                            <button type="submit" class="btn btn-danger">
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