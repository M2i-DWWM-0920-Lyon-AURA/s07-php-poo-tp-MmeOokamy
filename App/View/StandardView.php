<?php

namespace App\View;

use App\Core\AbstractView;

class StandardView extends AbstractView
{
    /**
     * @var array $templates List of templates to display inside body
     * @var array $variables Associative array matchin variables names to values
     */
    protected $templates, $variables;

    /**
     * Create new standard view
     * 
     * @param array $templates List of templates to display inside body
     * @param array $variables Associative array matchin variables names to values
     */
    public function __construct(array $templates, array $variables = [])
    {
        $this->templates = $templates;
        $this->variables = $variables;
    }

    /**
     * Render page head
     */
    protected function renderHead(): void
    {
        // Inclue le template meta
        include './templates/head.php';

    }

    /**
     * Render page body
     */
    protected function renderBody(): void
    {
        // Pour chaque couple de nom de variable/valeur
        foreach ($this->variables as $varName => $value) {
            // Crée une variable qui a pour nom le contenu de $varName
            // et lui assigne la valeur correspondante
            $$varName = $value;
        }

        echo '<header>' . PHP_EOL;
        
        echo '</header>' . PHP_EOL;

        echo '<div class="container">' . PHP_EOL;
        echo '<main>' . PHP_EOL;
        // Inclue les templates fournis lors de la création de l'objet
        foreach ($this->templates as $template) {
            include './templates/' . $template . '.php';
        }
        echo '</main>' . PHP_EOL;
        echo '</div>' . PHP_EOL;


    
        // Inclue le template footer
        include './templates/footer.php';
    }
}
