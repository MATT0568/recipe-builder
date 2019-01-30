<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recipe Builder: New User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css">
    <script src="main.js"></script>
</head>

<body>
    <?php include 'connect.php'; ?>

    <div class="container-fluid" id="header-footer">
        <nav class="navbar navbar-expand-lg">
            <img class="mr-3" src="assets/css/recipe-builder-logo.png" alt="Recipe Builder" id="logo">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            </ul>
        </nav>
    </div>

    <!-- MAIN PAGE CONTENT GOES INBETWEEN HERE -->
    <div id="page-content">
        <div class="card" id="create-user-form">
            <div class="card-header" id="card-header">
                Create Account
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="email">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        </select>
                    </div>
                    <br>
                    <button type="submit" id="submit" name="submit" class="btn btn-secondary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- MAIN PAGE CONTENT ENDS HERE -->

    <div class="container-fluid fixed-bottom" id="header-footer">
        <footer class="page-footer font-small">
            <div class="footer-copyright text-center py-3">© 2018 Copyright:
                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">TheZFighters</a>
            </div>
        </footer>
    </div>

    <?php
   //if the form is submitted then call add user function to create user
     if (isset($_POST['submit'])) {
       $first_name = $conn->real_escape_string($_POST['first_name']);
       $last_name = $conn->real_escape_string($_POST['last_name']);
       $email = $conn->real_escape_string($_POST['email']);
       $password = $conn->real_escape_string($_POST['password']);
       $stid=$conn->prepare("CALL add_user(?,?,?,?)");
       $stid->bind_param('ssss', $email, $password, $first_name, $last_name) or die($stid->error);
       $stid->execute();
       if ($stid->error){
         echo "Error";
       }
       else{
         header('Location: index.php');
       }
   }
   ?>

</body>

</html>