<?php

namespace App\Model;

use App\Core\AbstractModel;


final class TodoModel extends AbstractModel
{
    protected $description;
    protected $done;

    public function __construct(?int $id = null, string $description = '', bool $done = false)
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
     * Find all todo in database
     * 
     * @return array
     */
    static public function findAll(): array
    {
        return parent::findAllInTable('todos');
    }

    /**
     * Find a single quiz by ID
     * 
     * @param int $id Database ID
     * @return TodoModel|null
     */
    static public function findById(int $id): TodoModel
    {
        return parent::findByIdInTable('todos', $id);
    }

    /**
     * Create new record in database based on this object's properties
     */
    protected function insert(): void
    {
        $this->insertInTable(
            'todos',
            [
                'description' => 'description',
            ]
        );
    }

    /**
     * Update matching existing record in database based on this object's properties
     */
    protected function update(): void
    {
        $this->updateInTable(
            'todos',
            [
                'description' => 'description',
            ]
        );
    }

    /**
     * Remove matching recod from database
     */
    public function delete(): void
    {
        $this->deleteInTable('todos');
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
}