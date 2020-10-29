# Travaux pratiques - PHP modèle MVC

## Installation

- Cloner le projet.
- Importer le fichier **php-todos.sql** dans Adminer.
- Installer les dépendances avec la commande `composer install`.

## Travail à réaliser

L'objectif est de mettre en place un CRUD pour une liste de tâches à réaliser sous la forme d'une application MVC. En fonction de ton aisance avec la programmation orientée objet, tu es libre d'utiliser ou non les différentes abstractions étudiées en cours; mais ton application devra au minimum contenir:

- Une classe capable d'interagir avec la base de données (modèle),
- Une classe capable de réagir de manière adéquate aux requêtes de l'utilisateur (contrôleur),
- Des templates permettant de construire des pages HTML complètes (vues).

Tu dois implémenter les fonctionnalités suivantes, avec tous les éléments que cela implique (bouton/formulaire, envoi de la requête, traitement de la requête par un contrôleur, accès à la base de données, renvoie de la réponse):

| Méthode HTTP | URL | Fonctionnalité |
|---|---|---|
| `GET` | `/` | Affiche une page d'accueil |
| `GET` | `/todos` | Affiche la liste des tâches à faire |
| `POST` | `/todos/new` | Crée une nouvelle tâche à faire |
| `POST` | `/todos/:id/update` | Modifie une tâche à faire existante |
| `POST` | `/todos/:id/delete` | Supprime une tâche à faire existante |

## Bonus

- Lorsqu'on revient sur la liste des tâches après avoir effectué une modification en base de données, un message doit informer l'utilisateur du succès de l'opération.
- Valider les formulaires avant d'effectuer les modifications en base de données (par exemple, le nom d'une tâche à faire ne devrait pas être vide et ne peut pas faire plus de 255 caractères).
- Offrir un moyen de réordonner les tâches à faire.
- Pour chaque tâche à faire, une _checkbox_ doit permettre de modifier son état (terminé/pas terminé) lorsque l'on clique dessus (donc, sans avoir besoin de valider un formulaire).