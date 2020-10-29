<?php
namespace App\Model;

use App\Core\DatabaseHandler;

final class Todo 
{
    protected $id;
    protected $description;
    protected $done;

    public function __construct(?int $id = null, string $description = '', bool $done = false)
    {
        $this->id = $id;
        $this->description = $description;
        $this->done = $done;
    }
}