<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        body {
    background-image: url('images/pexels-marc-mueller-380769.jpg');
    background-size: cover;
    background-position: center;
    background-color: rgba(0, 0, 0, 0.8); /* Set opacity to 80% */
}


    </style>
</head>

<body >

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background-image: url('images/sgpo consulting logo.png');" ></div>



                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue!</h1>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center text-center">
                                    <button onclick="toggleForm('user')" class="btn mr-2" style="background-color: #e66f03; color: white;">Stagiaire Login</button>
                                    <button onclick="toggleForm('admin')" class="btn" style="background-color: #e66f03; color: white;">Admin Login</button>

                                    </div>

                                    <div id="user-login" class="login-form">
                                        <!-- User login form -->
                                        <div class="row justify-content-center align-items-center mt-5">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto">
                                                <div class="card shadow p-4 formShadow">
                                                    <h2 class="card-title">Stagiaire Login</h2>
                                                    <form id="user-login-form" method="post" action="functions.php">
                                                        <input type="hidden" name="userType" value="stagiaire">
                                                        <div class="form-group">
                                                            <label for="username" class="sr-only">Username</label>
                                                            <input type="text" class="form-control" id="username" placeholder="Username" name="Username">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="password" class="sr-only">Password</label>
                                                            <input type="password" class="form-control" placeholder="Password" name="Password">
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-block" style="background-color: #e66f03; color: white;" id="submit" onclick="login('user')">Login</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="admin-login" class="login-form" style="display: none;">
                                        <!-- Admin login form -->
                                        <div class="row justify-content-center align-items-center mt-5">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto">
                                                <div class="card shadow p-4 formShadow">
                                                    <h2 class="card-title">Admin Login</h2>
                                                    <form id="admin-login-form" method="post" action="functions.php">
                                                        <input type="hidden" name="userType" value="admin">
                                                        <div class="form-group">
                                                            <label for="username" class="sr-only">Username</label>
                                                            <input type="text" class="form-control" id="username" placeholder="Username" name="Username">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="password" class="sr-only">Password</label>
                                                            <input type="password" class="form-control" placeholder="Password" name="Password">
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-block" style="background-color: #e66f03; color: white;" id="submit" onclick="login('admin')">Login</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleForm(formType) {
            $('.login-form').hide();
            $('#' + formType + '-login').show();
        }

        function login() {
            // Perform login logic here

            // Redirect user to user page
            window.location.href = 'profile.php';
        }
    </script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
