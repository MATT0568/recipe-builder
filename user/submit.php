<?php
  include('validate.php');
  include('../connect.php');
  $recipe_name = $conn->real_escape_string($_POST['recipe_name']);
  $total_calories = intval($_POST['total_calories']);
  $data = $_POST['data'];
  print_r($data);

  for ($i = 1; $i < count($data); $i++) {
    $ingredient = $conn->real_escape_string($data[$i][0]);
    $amount = $conn->real_escape_string($data[$i][1]);
    $calories = $conn->real_escape_string($data[$i][2]);
    echo $ingredient . " " . $amount . " " . $calories . " ";

    $result = $conn->query("SELECT INGREDIENT_ID FROM INGREDIENT WHERE INGREDIENT_NAME = '$ingredient'");
    if ($result->num_rows == 0 && $ingredient !== "") {
      $stid=$conn->prepare("INSERT INTO INGREDIENT (ingredient_name) VALUES (?)");
      $stid->bind_param('s', $ingredient) or die($stid->error);
      $stid->execute();
      $ingredient_id = mysqli_insert_id($conn);
      $stid->close();
    }

    $email = $_SESSION['email'];
    $query = "SELECT * from APP_USERS where email = '$email'";
    $result = $conn->query($query);
    $row = $result->fetch_array();
    $user_id = intval($row['USER_ID']);
    echo $user_id;

    $result = $conn->query("SELECT RECIPE_ID FROM RECIPE WHERE RECIPE_NAME = '$recipe_name' AND USER_ID = '$user_id'");
    if ($result->num_rows == 0 && $recipe_name !== "") {
      $stid=$conn->prepare("INSERT INTO RECIPE (recipe_name, total_calories, user_id) VALUES (?,?,?)");
      $stid->bind_param('sii', $recipe_name, $total_calories, $user_id) or die($stid->error);
      $stid->execute();
      $recipe_id = mysqli_insert_id($conn);
      $stid->close();
    }

  
    $query = "SELECT * from INGREDIENT where ingredient_name = '$ingredient'";
    $result = $conn->query($query);
    $row = $result->fetch_array();
    $ingredient_id = $row['INGREDIENT_ID'];
    
    $stid=$conn->prepare("INSERT INTO INGREDIENTS (ingredient_id, recipe_id, calories, amount) VALUES (?,?,?,?)");
    $stid->bind_param('iiis', $ingredient_id, $recipe_id, $calories, $amount) or die($stid->error);
    $stid->execute();
    $stid->close();
  }
?>