<?php require_once("../initialize.php"); ?>
<?php	
    $session->logout();
    redirect_to("login.php");
?>
