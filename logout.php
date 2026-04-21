<?php
session_start();
session_unset();
session_destroy();
header("Location: Pagina_Inicio.php");
exit();
?>