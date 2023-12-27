<?php
$title = "Mon portfolio - Ajout d'une création";
?>
<h1>Ajout d'une création</h1>
<?php
if (!empty($erreur)) {
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $erreur; ?>
    </div>
<?php
}
?>

<?php
var_dump($_GET['cookie']);
echo $addForm;
