<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recipe Builder: Build Recipe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/style.css">
    <?php include('validate.php'); ?>
    <?php include('../connect.php'); ?>
</head>

<body>
    <div class="container-fluid fixed-top" id="header-footer">
        <nav class="navbar navbar-expand-lg">
            <img class="mr-3" src="../assets/css/recipe-builder-logo.png" alt="Recipe Builder" id="logo">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Create Recipe<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="my-recipes.php">My Recipes</a>
                    </li>

                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <a class="nav-link" href="/">Logout<span class="sr-only"></span></a>
                </form>
            </div>
        </nav>
    </div>
    <br>
    <br>
    <br>
    <!-- MAIN PAGE CONTENT GOES INBETWEEN HERE -->
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-md-6 mr-5" id="add-recipe-form">
                <div class="card" id="build-recipe-card">
                    <div class="card-header" id="card-header">
                        Build Recipe
                    </div>
                    <div class="card-body pr-5">
                        <form method="post" class="form-row">
                            <div class="col-md-6">
                                <label for="ingredient" class="label">Ingredient:</label>
                                <input type="text" class="form-control" list="add-ingredient" id="ingredient"
                                    autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label id="amountLabel" class="label" for="amount">Amount:</label>
                                <input type="number" class="form-control" id="amount" autocomplete="off">
                            </div>
                            <div class="col-md-1">
                                <label class="label" for="submit-ingredient">&nbsp;</label>
                                <button name="submit-ingredient" type="submit" id="submit-ingredient" class="btn btn-success mb-2">Add
                                    Ingredient</button>
                            </div>
                            <datalist id="add-ingredient">
                            </datalist>
                        </form>
                        <form method="post" action="" class="label">
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="label" for="recipe-name">Recipe Name:</label>
                                    <input class="form-control" id="recipe-name">
                                    <br>
                                </div>
                                <div class="col-md-1">
                                    <label class="label" for="submit-recipe">&nbsp;</label>
                                    <button name="submit-recipe" id="submit-recipe" type="submit" class="btn btn-success">Save
                                        Recipe</button>
                                </div>
                                <div class="col-md-12">
                                    <div class="card form-group">
                                        <div class="card-header" id="card-header">
                                            Ingredients List
                                        </div>
                                        <div class="card-body" id="ingredients-list">
                                            <table class="table table-hover" id="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Ingredient</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Calories</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rows">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4 ml-5">
                <div class="card" id="similar-recipes-card">
                    <div class="card-header" id="card-header">
                        Similar Recipes
                    </div>
                    <div id="similar-recipes-card">
                        <div class="card-body">
                            <div id="similar"></div>
                        </div>
                    </div>
                </div>
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

    <script src="../assets/javascript/index.js"></script>
</body>

</html>