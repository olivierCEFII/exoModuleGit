<?php
$title = "Mon portfolio - " . $creation->title;
?>
<article class=" row justify-content-center text-center">
    <h1 class="col-12"><?php echo $creation->title; ?></h1>;
    <p>Date de publication:<?php echo date("d/m/Y", strtotime($creation->created_at)); ?></p>
    <img class="col-4" src="<?php echo $creation->picture; ?>" alt="<?php echo $creation->title; ?>">
    <p><?php echo $creation->description; ?></p>
</article>