<?php

namespace App\Core;

// ================================================================
// Template method
// ----------------------------------------------------------------
// https://refactoring.guru/fr/design-patterns/template-method
// ----------------------------------------------------------------
// ~ Template method est un design pattern (schéma de conception)
// qui permet de définir une structure d'algorithme dans une
// classe, mais de laisser les classes dérivées définir certaines
// parties de cet algorithme, sans changer sa structure. En
// l'occurrence, la classe AbstractView définit la façon générale
// d'afficher une page HTML dans sa méthode render(), mais laisse
// d'autres classes (comme StandardView) décider de la manière
// d'afficher le contenu de <head> et celui de <body>.
// ================================================================

abstract class AbstractView
{
    // La méthode render() est déclarée "finale" afin d'empêcher les
    // classes dérivées de la redéfinir

    /**
     * Render page as HTML
     */
    final public function render()
    {
        // Ecrit le contenu de la page
        echo '<!DOCTYPE html>' . PHP_EOL;
        echo '<html lang="fr">' . PHP_EOL;
        echo '<head>' . PHP_EOL;

        // Laisse la classe dérivée décider de l'affichage du <head>
        $this->renderHead();

        echo '</head>' . PHP_EOL;
        echo '<body>' . PHP_EOL;

        // Laisse la classe dérivée décider de l'affichage du <body>
        $this->renderBody();

        echo '</body>' . PHP_EOL;
        echo '</html>' . PHP_EOL;
    }

    // Force toutes les classes dérivées à implémenter les méthodes
    // renderHead() et renderBody() utilisées dans render(), car on
    // sait à l'avance qu'elles sont nécessaires à son bon fonctionnement

    /**
     * Render page head
     */
    abstract protected function renderHead(): void;

    /**
     * Render page body
     */
    abstract protected function renderBody(): void;
}
