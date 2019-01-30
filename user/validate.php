<?php
  session_start();

  if (!isset($_SESSION['email'])){
    header('Location: ../index.php');
  }
 ?>

<link rel="stylesheet" href="../assets/css/style.css">
