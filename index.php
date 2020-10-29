<?php

// ================================================================
// Front controller
// ----------------------------------------------------------------
// ~ Toutes les requêtes sont redirigées sur ce fichier grâce au
// fichier .htaccess.
// ================================================================

// Active le chargement automatique des classes grâce à Composer
require 'vendor/autoload.php';

use App\Core\AbstractView;
use App\Model\TodoModel;

// Crée un nouveau routeur
$router = new AltoRouter();


// ================================================================
// Routes
// ----------------------------------------------------------------
// ~ Associe une fonction à chaque route disponible dans notre 
// application.
// ================================================================

// Page d'accueil

$router->map('GET', '/', function() {
    require __DIR__ . '/pages/home.php';
});

// Page des tâches à faire
$router->map('GET', '/todo', 'ListeController#todo');
$router->map('POST', '/todo/new', 'ListeController#todo');
$router->map('POST', '/todo/:id/update', 'ListeController#update');
$router->map('POST', '/todo/:id/delete', 'ListeController#delete');


// ================================================================
// Routeur
// ----------------------------------------------------------------
// ~ Le routeur récupère la fonction associée à la route demandée
// et l'exécute, ou produit une page 404 si aucune route n'a été
// trouvée.
// ~ Cette partie du code vérifie que vous avez bien associé une
// fonction à chaque route, sinon elle produit une erreur.
// ================================================================

// Cherche une correspondance entre la requête de l'utilisateur et les routes connues
$match = $router->match();

// Si une correspondance a été trouvée
if( is_array($match)) {
	// Si la valeur renvoyée par le routeur n'est pas une fonction
	if (!is_callable( $match['target'] )) {
		// Produire une erreur
		$type = gettype($match['target']);
		return new TypeError("Routes must return a function ($type given).");
	}
	// Appelle la fonction associée à la route
	call_user_func_array( $match['target'], $match['params'] ); 
// Sinon
} else {
	// Renvoie la page 404 du serveur
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
