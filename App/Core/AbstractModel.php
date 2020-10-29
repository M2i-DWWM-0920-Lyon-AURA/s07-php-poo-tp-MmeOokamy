<?php

namespace App\Core;
use App\Core\DatabaseHandler;

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

    /**
     * Fetch first result from a database query and returns null if no record was found
     * 
     * @static
     * @param \PDOStatement $statement PDO statement from which to retrieve results
     * @return AbstractModel|null
     */
    static protected function fetchOneOrNull(\PDOStatement $statement): ?AbstractModel
    {
        // Récupère tous les résultats de la requête sous forme d'objets
        $result = static::fetchAllFromStatement($statement);

        // Si la liste des résultats est vide, renvoyer null
        if (empty($result)) {
            return null;
        }

        // Sinon, renvoyer le premier résultat de la liste
        return $result[0];
    }
    
    /**
     * Find all records in given database table
     * 
     * @static
     * @param string $tableName Database table name to query
     * @return array
     */
    static protected function findAllInTable(string $tableName): array
    {
        $statement = DatabaseHandler::query("SELECT * FROM `$tableName`");
        return static::fetchAllFromStatement($statement);
    }

    /**
     * Find a single record in given database table by ID
     * 
     * @static
     * @param string $tableName Database table name to query
     * @param int $id Database ID
     * @return AbstractModel|null
     */
    static protected function findByIdInTable(string $tableName, int $id): ?AbstractModel
    {
        $statement = DatabaseHandler::prepare("SELECT * FROM `$tableName` WHERE `id` = :id");
        $statement->execute([ ':id' => $id ]);
        return static::fetchOneOrNull($statement);
    }

    /**
     * Find records matching condition (property equals value) in given database
     * 
     * @static
     * @param string $tableName Database table name to query
     * @param string $propName Property name
     * @param string $value Value to look for in property
     */
    static protected function findWherePropEqualInTable(string $tableName, string $propName, string $value): array
    {
        $statement = DatabaseHandler::prepare("SELECT * FROM `$tableName` WHERE `$propName` = :val");
        $statement->execute([ ':val' => $value ]);
        return static::fetchAllFromStatement($statement);
    }

    /**
     * Save current object state in database
     */
    public function save(): void
    {
        // Si l'objet n'existe pas encore en base de données
        if (is_null($this->getId())) {
            // Crée un nouvel enregistrement en base de données correspondant à cet objet
            $this->insert();
        // Sinon
        } else {
            // Met à jour les propriétés de l'enregistrement existant correspondant à cet objet
            $this->update();
        }
    }

    /**
     * Create new record in given database table based on this object's properties
     * 
     * @param string $tableName Database table name to query
     * @param array $properties Associative array matching each model's property with matching database table column
     */
    protected function insertInTable(string $tableName, array $properties): void
    {
        $params = [];
        // Pour chaque paramètre passé par le modèle concret
        foreach ($properties as $propName => $dbName) {
            // Construit un tableau avec les noms des paramètres entre bacticks (`)
            // Ce sera la liste des propriétés à définir dans la table
            $propNames []= "`$dbName`";
            // Construit un autre tableau avec les noms des paramètres précédés par un :
            // Ce sera la liste des champs variables dans lesquels on injectera les valeurs
            $valueNames []= ":$propName";
            // Construit un autre tableau faisant correspondre à chaque nom de champ variable
            // la valeur de l'objet qu'il faudra injecter
            $params[":$propName"] = $this->$propName;
        }

        // Fusionne la liste des propriétés à définir en joignant chaque élément avec une virgule
        $propNames = join(', ', $propNames);
        // Fusionne la liste des champs variables en joignant chaque élément avec une virgule
        $valueNames = join(', ', $valueNames);

        // Construit un tableau qui contient les différentes lignes de la requête
        $queryArray = [
            // Ajoute la commande et le nom de la table concernée
            "INSERT INTO `$tableName`",
            // Ajoute les propriétés à définir
            '( ' . $propNames . ' )',
            // Ajoute des champs variables correspondants aux propriétés
            'VALUES (' . $valueNames . ')',
        ];
        // Fusionne le tableau en joignant chaque élément avec un saut de ligne (\n)
        $query = join("\n", $queryArray);

        // Prépare la requête et l'exécute en injectant les valeurs de l'objet actuel
        $statement = DatabaseHandler::prepare($query);
        $statement->execute($params);

        // Récupère le dernier ID inséré en base de données et l'affecte à cet objet
        // Cela évite que l'objet continue à se comporter comme s'il n'existait pas
        // encore en base de données
        $this->id = DatabaseHandler::lastInsertId();
    }

    /**
     * Update matching existing record in given database table based on this object's properties
     * 
     * @param string $tableName Database table name to query
     * @param array $properties Associative array matching each model's property with matching database table column
     */
    protected function updateInTable(string $tableName, array $properties): void
    {
        // Ajoute l'ID aux paramètres passés par le modèle concret
        $params = [ ':id' => $this->getId() ];
        // Pour chaque paramètre passé par le modèle concret
        foreach ($properties as $propName => $dbName) {
            // Construit un tableau avec le nom de propriété entre backticks (`) égal à un champ variable
            // précédé d'un :
            $values []= "`$dbName` = :$propName";
            // Construit un autre tableau faisant correspondre à chaque nom de champ variable
            // la valeur de l'objet qu'il faudra injecter
            $params[":$propName"] = $this->$propName;
        }

        // Fusionne la liste des propriétés à définir en joignant chaque élément avec une virgule
        // et un saut de ligne (\n)
        $values = join(",\n", $values);

        // Construit un tableau qui contient les différentes lignes de la requête
        $queryArray = [
            // Ajoute la commande et le nom de la table concernée
            "UPDATE `$tableName`",
            'SET',
            // Ajoute la liste des propriétés 
            $values,
            // Ajoute la condition permettant d'identifier l'enregistrement à modifier
            "WHERE `id` = :id"
        ];
        // Fusionne le tableau en joignant chaque élément avec un saut de ligne (\n)
        $query = join("\n", $queryArray);

        // Prépare la requête et l'exécute en injectant les valeurs de l'objet actuel
        $statement = DatabaseHandler::prepare($query);
        $statement->execute($params);
    }

    /**
     * Remove matching recod from given database table
     * 
     * @param string $tableName Database table name to query
     */
    protected function deleteInTable(string $tableName): void
    {
        $statement = DatabaseHandler::prepare("DELETE FROM `$tableName` WHERE `id` = :id");
        $statement->execute([ ':id' => $this->id ]);

        $this->id = null;
    }

    /**
     * Create a new model from a collection of values returned from database
     */
    public function createInstance(...$params): AbstractModel
    {
        // Récupère le nom de la classe depuis laquelle cette méthode a été appelée
        $className = \get_called_class();
        // Crée une nouvelle instance de la classe demandée, et passe à son constructeur
        // l'ensemble des arguments passés à cette fonction
        return new $className(...$params);
    }

    // ================================================================
    // Méthodes abstraites
    // ----------------------------------------------------------------
    // ~ Une méthode abstraite est une simple déclaration de méthode
    // (visibilité, nom, paramètres, type de retour), sans contenu.
    // Cela oblige les classes dérivant de celle-ci à implémenter
    // l'ensemble de ces méthodes, car l'on sait qu'elles sont
    // indispensables à leur bon fonctionnement. Mais comme ces
    // méthodes n'ont pas de sens en-dehors d'un modèle concret
    // (associé à une table en base de données), on ne les définit pas
    // dans la classe abstraite; on se contente d'exiger sa présence
    // dans chaque classe dérivée.
    // ================================================================

    /**
     * Find all records in database
     * 
     * @abstract
     * @static
     * @return array
     */
    abstract static public function findAll(): array;

    /**
     * Find a single record by ID
     * 
     * @abstract
     * @static
     * @param int $id Database ID
     * @return AbstractModel|null
     */
    abstract static public function findById(int $id): ?AbstractModel;

    /**
     * Create new record in database based on this object's properties
     * 
     * @abstract
     */
    abstract protected function insert(): void;

    /**
     * Update matching existing record in database based on this object's properties
     * 
     * @abstract
     */
    abstract protected function update(): void;

    /**
     * Remove matching recod from database
     * 
     * @abstract
     */
    abstract public function delete(): void;
}
