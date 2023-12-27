<?php

namespace App\Core;

class Router
{

    public function routes()
    {
        //On teste si la superglobale $_GET['controller'] est déclarée et non vide, puis on ajoute le premier index de $_GET dans la variable
        //$controller, ou par défaut 'home', ainsi que son namespace, plus le mot Controller 
        //pour compléter le nom de la classe controller à instancier.
        $controller = (isset($_GET['controller']) ? ucfirst(array_shift($_GET)) : 'home');
        $controller = '\\App\\Controllers\\' . $controller . 'Controller';

        //On teste si la superglobale $_GET['action'] est déclarée et non vide, puis on ajoute le premier index de $_GET dans la variable
        //$action, ou par défaut 'index'.
        $action = (isset($_GET['action']) ? array_shift($_GET) : 'index');

        // On instancie le contrôleur
        $controller = new $controller();
        $controller->$action();
        // if (method_exists($controller, $action)) {
        //     // Si $_GET contient des index, on exécute la méthode en passant comme argument les paramètres de $_GET ou alors
        //     // on exécute la méthode sans argument.
        //     (isset($_GET)) ? call_user_func_array([$controller, $action], $_GET) : $controller->$action();
        // } else {
        //     // On envoie le code réponse 404
        //     http_response_code(404);
        //     echo "La page recherchée n'existe pas";
        // }
    }
}
