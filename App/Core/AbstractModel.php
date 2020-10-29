<?php

namespace App\Core;
use App\Core\DatabaseHandler;
use App\Model\TodoModel;

abstract class AbstractModel
{
   
    /**
     * @var int $id Database ID
     */
    protected $id;

    /**
     * Create new model
     * 
     * @param int $id Database ID
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    /**
     * Get the value of id
     * 
     * @return int|null
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    // ================================================================
    // Relations
    // ----------------------------------------------------------------
    // ~ Ces méthodes permettent de gérer les relations entre des
    // couples de modèles. Par exemple, si un article peut appartenir
    // à une et une seule catégorie (Many-To-One), et qu'une catégorie
    // peut contenir n'importe quel nombre d'articles (One-To-Many),
    // la méthode getManyToOne(Category::class, 'category_id')
    // permettra à un Article d'accéder à sa catégorie, alors que la
    // méthode getOneToMany(Article::class, 'category_id') permettra à
    // une Category de récupérer la liste de ses articles.
    // ================================================================
    
    /**
     * Get related entity in a Many-To-One relaiton
     * 
     * @param string $otherClass Related entity's class name
     * @param string $propName Name of this object's property holding the related object's id
     * @return AbstractModel|null
     */
    protected function getManyToOne(string $otherClass, string $propName): ?AbstractModel
    {
        return $otherClass::findById($this->$propName);
    }

    /**
     * Set related entity in a Many-To-One relaiton
     * 
     * @param AbstractModel $otherClass Related entity instance
     * @param string $propName Name of this object's property holding the related object's id
     * @return self
     */
    protected function setManyToOne(AbstractModel $instance, string $propName): self
    {
        $this->$propName = $instance->getId();

        return $this;
    }

    /**
     * Get related entities in a One-To-Many relaiton
     * 
     * @param string $otherClass Related entity's class name
     * @param string $propName Name of related object's property holding this object's id
     * @return array
     */
    protected function getOneToMany(string $otherClass, string $propName): array
    {
        return $otherClass::findWherePropEqual($propName, $this->getId());
    }

    // ================================================================
    // Accès à la base de données
    // ----------------------------------------------------------------
    // ~ Ces méthodes permettent aux modèles d'interagir avec la base
    // de données, aussi bien pour des requêtes (find*) que pour des
    // mutations (insert, update, delete). Ces méthodes sont destinées
    // à être appelées par les modèles concrets, qui devront donc leur
    // passer le nom de la table concernée (ainsi que la liste des
    // colonnes, le cas échéant).
    // ================================================================

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

    static protected function fetchAll(): array
    {
        $statement = DatabaseHandler::query('SELECT * FROM `todos` ORDER BY `id`');
        return $statement->fetchAll();
    }

    
}
