<?php
// On démarre la session
session_start ();

// On détruit les variables de notre session
session_unset ();

// On détruit notre session
session_destroy ();

// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("j.benaim@orange.fr","My subject",$msg);

// On redirige le visiteur vers la page d'accueil
// header('Location: ../index.php');

?>
