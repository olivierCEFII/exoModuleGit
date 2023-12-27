<?php $title = "Mon portfolio - liste de mes créations" ?>
<?php
if ($message == "true") {
?>
    <div class="alert alert-success" role="alert">
        Votre demande a bien été prise en compte
    </div>
<?php
} elseif ($message == "false") {
?>
    <div class="alert alert-danger" role="alert">
        Une erreur est survenue
    </div>
<?php
}
?>
<h2>Liste de mes créations</h2>
<a href="index.php?controller=creation&action=add"><button type="button" class="btn btn-primary">Ajouter une création</button></a>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">description</th>
            <th scope="col">created_at</th>
            <th scope="col">picture</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //On boucle dans le tableau $list qui contient la liste des créations
        foreach ($list as $value) {
            echo "<tr>";
            echo "<td>" . $value->id_creation . "</td>";
            echo "<td>" . $value->title . "</td>";
            echo "<td>" . $value->description . "</td>";
            echo "<td>" . date("d/m/Y", strtotime($value->created_at)) . "</td>";
            echo "<td><img src='$value->picture' class='picture'></td>";
            echo "<td><a href='index.php?controller=creation&action=showCreation&id=$value->id_creation'><i class='fas fa-eye'></i></a></td>";
            echo "<td><a href='index.php?controller=creation&action=updateCreation&id=$value->id_creation'><i class='fas fa-pen'></i></a></td>";
            echo "<td><a href='index.php?controller=creation&action=deleteCreation&id=$value->id_creation'><i class='fas fa-trash-alt'></i></a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>