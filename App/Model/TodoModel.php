<?php

namespace App\Model;

use App\Core\DatabaseHandler;

final class TodoModel 
{
    protected $id;
    protected $description;
    protected $done;

    public function __construct(
        int $id = null,
        string $description = '',
        int $done = 0
    )
    {
        $this->id = $id;
        $this->description = $description;
        $this->done = $done;
        
    }

   

    /**
     * Fetch all results from a database query
     * 
     * @static
     * @param \PDOStatement $statement PDO statement from which to retrieve results
     * @return array
     */
    static protected function fetchAllFromStatement(\PDOStatement $statement): array
    {
        // Récupère le nom de la classe depuis laquelle cette méthode a été appelée
        $className = \get_called_class();
        // Demande à l'interface de base de données de récupérer l'ensemble
        // des résultats de la requête, en passant chaque résultat à travers
        // la fonction createInstance() de la classe appelante
        return $statement->fetchAll(\PDO::FETCH_FUNC, [$className, 'createInstance']);
    }

    static public function createTodo($id, $description, $done)
    {
        return new TodoModel($id, $description, $done);
    }

    static public function fetchAll(): array
    {
        $statement = DatabaseHandler::query('SELECT * FROM `todos` ORDER BY `id`');
        return $statement->fetchAll();
    }

 

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of done
     */ 
    public function getDone(): int
    {
        return $this->done;
    }

    /**
     * Set the value of done
     *
     * @return  self
     */ 
    public function setDone(int $done)
    {
        $this->done = $done;

        return $this;
    }

    
}


