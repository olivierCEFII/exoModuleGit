<?php

namespace App\Models;

use Exception;
use App\core\DbConnect;
use App\Entities\Creation;

class CreationModel extends DbConnect
{
    public function findAll()
    {

        $this->request = "SELECT * FROM creation";
        $result = $this->connection->query($this->request);
        $list = $result->fetchAll();
        return $list;
    }

    public function find(int $id)
    {
        $this->request = $this->connection->prepare("SELECT * FROM creation WHERE id_creation = :id_creation");
        $this->request->bindParam(":id_creation", $id);
        $this->request->execute();
        $creation = $this->request->fetch();
        return $creation;
    }

    public function create(Creation $creation)
    {

        $this->request = $this->connection->prepare("INSERT INTO creation VALUES (NULL, :title, :description, :created_at, :picture)");
        $this->request->bindValue(":title", $creation->getTitle());
        $this->request->bindValue(":description", $creation->getDescription());
        $this->request->bindValue(":created_at", $creation->getCreated_at());
        $this->request->bindValue(":picture", $creation->getPicture());
        $message = $this->executeTryCatch();
        return $message;
    }

    public function update(int $id, Creation $creation)
    {
        $this->request = $this->connection->prepare("UPDATE creation 
                                                     SET title = :title, description = :description, created_at = :created_at, picture = :picture 
                                                     WHERE id_creation = :id_creation");
        $this->request->bindValue(":id_creation", $id);
        $this->request->bindValue(":title", $creation->getTitle());
        $this->request->bindValue(":description", $creation->getDescription());
        $this->request->bindValue(":created_at", $creation->getCreated_at());
        $this->request->bindValue(":picture", $creation->getPicture());
        $message = $this->executeTryCatch();
        return $message;
    }

    public function delete(int $id)
    {
        $this->request = $this->connection->prepare("DELETE FROM creation WHERE id_creation = :id_creation");
        $this->request->bindParam("id_creation", $id);
        $message = $this->executeTryCatch();
        return $message;
    }

    private function executeTryCatch()
    {
        try {
            $message = $this->request->execute();
            return $message;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        // Ferme le curseur, permettant à la requête d'être de nouveau exécutée
        $this->request->closeCursor();
    }
}
