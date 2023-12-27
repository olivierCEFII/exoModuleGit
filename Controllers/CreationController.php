<?php

namespace App\Controllers;

use App\Core\Form;
use App\Entities\Creation;
use App\Models\CreationModel;

class CreationController extends Controller
{

    //Méthode qui permet d'afficher la liste des créations
    public function index(string $message = "")
    {
        //on instancie la classe CreationModel
        $creations = new CreationModel();

        //on stocke dans une variable le return de la methode findAll()
        $list = $creations->findAll();

        $this->render('creation/index', ['list' => $list, 'message' => $message]);
    }

    //Méthode d'ajout d'une création
    public function add()
    {
        //on contrôle si les champs du formulaire sont remplis
        if (Form::validatePost($_POST, ['title', 'description', 'date']) && Form::validateFiles($_FILES, ['picture'])) {

            //upload de l'image dans le dossiers "images"
            move_uploaded_file($_FILES["picture"]["tmp_name"], "images/" . $_FILES["picture"]["name"]);
            //on stocke le chemin de l'image
            $picture = "images/" . $_FILES["picture"]["name"];

            //on instancie l'entité "Creation"
            $creation = new Creation();

            //on l'hydrate
            $creation->setTitle($_POST['title']);
            $creation->setDescription($_POST['description']);
            $creation->setCreated_at($_POST['date']);
            $creation->setPicture($picture);

            //on instancie le model "creation"
            $model = new CreationModel();
            $message = $model->create($creation);
            $message = ($message) ? "true" : "false";
            //on redirige l'utilisateur vers la liste des créations
            $this->redirectedToRoute('creation', 'index', $message);
        } else {
            //on affiche un message d'erreur
            $erreur = !empty($_POST) ? "Le formulaire n'a pas été correctement rempli" : "";
        }

        //on instancie la classe Form pour construire le formulaire d'ajout
        $form = new Form();

        //on construit le formulaire d'ajout
        $form->startForm("#", "POST", ["enctype" => "multipart/form-data"]);
        $form->addLabel("title", "Titre", ["class" => "form-label"]);
        $form->addInput("text", "title", ["id" => "title", "class" => "form-control", "placeholder" => "Ajouter un titre"]);
        $form->addLabel("description", "Description", ["class" => "form-label"]);
        $form->addTextarea("description", "description de la création", ["id" => "description", "class" => "form-control", "rows" => 15]);
        $form->addLabel("date", "Date de publication", ["class" => "form-label"]);
        $form->addInput("date", "date", ["id" => "date", "class" => "form-control"]);
        $form->addLabel("picture", "Image de la création", ["class" => "form-label"]);
        $form->addInput("file", "picture", ["id" => "picture", "class" => "form-control mb-2"]);
        $form->addInput("submit", "add", ["value" => "Ajouter", "class" => "btn btn-primary"]);
        $form->endForm();

        //on envoie le formulaire dans la vue add.php
        $this->render('creation/add', ["addForm" => $form->getFormElements(), "erreur" => $erreur]);
    }

    //Méthode pour afficher une création
    public function showCreation($id)
    {

        //On instancie la classe CreationModel

        $creations = new CreationModel();

        //on stocke dans une variable le return de la methode find()
        $creation = $creations->find($id);

        $this->render('creation/showCreation', ['creation' => $creation]);
    }

    //méthode pour la mise à jour de la création
    public function updateCreation($id)
    {
        //on contrôle si les champs du formulaire sont remplis
        if (Form::validatePost($_POST, ['title', 'description', 'date', 'hidden'])) {

            //on instancie l'entité "Creation"
            $creation = new Creation();

            //on l'hydrate
            $creation->setTitle($_POST['title']);
            $creation->setDescription($_POST['description']);
            $creation->setCreated_at($_POST['date']);

            //si une nouvelle image a été uploadée
            if (Form::validateFiles($_FILES, ['picture'])) {

                //upload de l'image dans le dossier "images"
                move_uploaded_file($_FILES["picture"]["tmp_name"], "images/" . $_FILES["picture"]["name"]);

                //on stocke le chemin de l'image
                $picture = "images/" . $_FILES["picture"]["name"];

                //on hydrate la propriété picture de la classe "Creation"
                $creation->setPicture($picture);

                //sinon on garde le lien de l'image par défaut du champ caché
            } else {
                $creation->setPicture($_POST['hidden']);
            }

            //on instancie le modèle "creation" pour l'update
            $creations = new CreationModel();
            $message = $creations->update($id, $creation);
            $message = ($message) ? "true" : "false";

            //on redirige l'utilisateur vers la liste des créations
            $this->redirectedToRoute('creation', 'index', $message);
        } else {

            //on affiche un message d'erreur
            $erreur = !empty($_POST) ? "Le formulaire n'a pas été correctement rempli" : "";
        }

        //on instancie le model pour récupérer les informations de la création 
        $creations = new CreationModel();
        $creation = $creations->find($id);

        //on construit le formulaire de mise à jour
        $form = new Form();

        $form->startForm("#", "POST", ["enctype" => "multipart/form-data"]);
        $form->addLabel("title", "Titre", ["class" => "form-label"]);
        $form->addInput("text", "title", [
            "id" => "title", "class" => "form-control", "placeholder" => "Ajouter un titre",
            "value" => $creation->title
        ]);
        $form->addLabel("description", "Description", ["class" => "form-label"]);
        $form->addTextarea("description", $creation->description, ["id" => "description", "class" => "form-control", "rows" => 15]);
        $form->addLabel("date", "Date de publication", ["class" => "form-label"]);
        $form->addInput("text", "date", ["id" => "date", "class" => "form-control", "value" => $creation->created_at, "readonly" => ""]);
        $form->addLabel("picture", "Image de la création", ["class" => "form-label"]);
        $form->addInput("file", "picture", ["id" => "picture", "class" => "form-control mb-2"]);
        $form->addInput("text", "hidden", ["id" => "hidden", "class" => "form-control", "value" => $creation->picture, "hidden" => ""]);
        $form->addInput("submit", "update", ["value" => "Modifier", "class" => "btn btn-primary"]);
        $form->endForm();

        //on renvoie vers la vue le formulaire de mise à jour et le message d'erreur potentiel
        $this->render('creation/updateCreation', ["updateForm" => $form->getFormElements(), "erreur" => $erreur, "picture" => $creation->picture]);
    }

    //méthode pour la suppression d'une création
    public function deleteCreation($id)
    {
        if (isset($_POST['true'])) {
            //on instancie la classe Creation Model pour exécuter la suppression avec la méthode delete()
            //en récupérant l'id de la création du lien "OUI"
            $creations = new CreationModel();
            $message = $creations->delete($id);
            $message = ($message) ? "true" : "false";
            //on redirige l'utilisateur vers la liste des créations
            $this->redirectedToRoute('creation', 'index', $message);
        } elseif (isset($_POST['false'])) {

            //on redirige l'utilisateur vers la liste des créations
            $this->redirectedToRoute('creation', 'index');
        } else {
            //on récupére la création avec la méthode find()
            $creations = new CreationModel();
            $creation = $creations->find($id);
        }
        //on renvoie vers la vue la création sélectionnée
        $this->render('creation/deleteCreation', ["creation" => $creation]);
    }
}
