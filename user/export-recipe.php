<?php include('../connect.php'); ?>
  <?php
  error_reporting(0);
  date_default_timezone_set("America/New_York");
  // creates query using filters
  $query = 'SELECT * FROM RECIPE_INFO WHERE 1=1';
  if(isset($_GET['id1'])){
    $query = $query . " and recipe_id = '".$_GET['id1']."'";
  }
  // checks to see if query returns anything. If it does then create column names and fill with specified data from the recipe_info view
  $result = $conn->query($query);
  if($result->num_rows > 0){
      $delimiter = ",";
      $filename = "recipe_" . date("m-d-y") . ".csv";

      $f = fopen('php://memory', 'w');

      $fields = array('ingredient_name', 'amount', 'calories');
      fputcsv($f, $fields, $delimiter);

      while($row = $result->fetch_assoc()){
        $lineData = array($row['INGREDIENT_NAME'], $row['AMOUNT'], $row['CALORIES']);
        fputcsv($f, $lineData, $delimiter);
      }

      fseek($f, 0);

      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="' . $filename . '";');

      fpassthru($f);
  }
  exit;
  ?>
