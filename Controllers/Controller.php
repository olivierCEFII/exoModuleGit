<?php

namespace App\Controllers;

abstract class Controller
{
    protected $paramPost;

    public function __construct()
    {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->paramPost[$key] = $this->protected_values($value);
            }
        }
    }
    public function render(string $path, array $data = [])
    {
        // Permet d'extraire les données récupérées sous forme de variables
        extract($data);

        //On créer le buffer de sortie
        ob_start();

        // Crée le chemin et inclut le fichier de la vue souhaitée
        include dirname(__DIR__) . '/Views/' . $path . '.php';

        //On vide le buffer dans les variables $title et $content
        $content = ob_get_clean();

        // On fabrique le "template"
        include dirname(__DIR__) . '/Views/base.php';
    }

    public function redirectedToRoute($controller, $action, $param = "")
    {

        header('HTTP/1.0 301 Moved Permanently');
        header('Location: index.php?controller=' . $controller . '&action=' . $action . "&message=" . $param);
        header('Connection: close');

        die();
    }
    private function protected_values($values)
    {
        $values = trim($values);
        $values = stripslashes($values);
        $values = htmlspecialchars($values);
        return $values;
    }
}
