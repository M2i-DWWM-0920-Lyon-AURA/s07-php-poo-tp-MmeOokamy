<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Core\DatabaseHandler;

final class TodoModel extends AbstractModel
{
    protected $description;
    protected $done;

    public function __construct(
        int $id = null,
        string $description = '',
        bool $done = false
    )
    {
        parent::__construct($id);
        $this
        ->setDescription($description)
        ->setDone($done)
        ;
    }

    

    /**
     * fetchall
     */

     static public function fetchall(): array
     {
        return parent::fetchAll();
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
    public function getDone(): bool
    {
        return $this->done;
    }

    /**
     * Set the value of done
     *
     * @return  self
     */ 
    public function setDone(bool $done)
    {
        $this->done = $done;

        return $this;
    }

    static public function createTodo($id, $name) {
        return new TodoModel($id, $name);
    }
}


