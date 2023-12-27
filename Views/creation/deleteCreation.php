<?php $title = "Mon portfolio - Suppression d'une création"; ?>

<div class="alert alert-warning" role="alert">
    <p>Voulez vous supprimer la création:<?php echo " " . "<strong>$creation->title</strong>"; ?>?</p>
    <form action="#" method="POST">
        <input class="btn btn-danger" type="submit" name="true" value="OUI">
        <input class="btn btn-primary" type="submit" name="false" value="NON">
    </form>
</div>