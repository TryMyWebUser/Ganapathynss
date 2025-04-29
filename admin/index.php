<?php

    include "../libs/load.php";

    // Start a session
    Session::start();

    // Redirect if the user is already logged in
    if (Session::get('login_user'))
    {
        header('Location: welcome.php');
        exit;
    }

    $error = "";

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Check if both username and password keys exist in $_POST
        if (isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']))
        {
            $username = $_POST['username'] ?? "";
            $password = $_POST['password'] ?? "";
            $error = User::login($username, $password);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title Meta -->
        <meta charset="utf-8" />
        <title>Login - Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="A fully responsive premium admin dashboard template" />
        <meta name="author" content="Techzaa" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico" />

        <!-- Vendor css (Require in all Page) -->
        <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

        <!-- Icons css (Require in all Page) -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <!-- App css (Require in all Page) -->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

        <!-- Theme Config js (Require in all Page) -->
        <script src="assets/js/config.min.js"></script>
    </head>

    <body class="authentication-bg">
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5">
                        <div class="card auth-card">
                            <div class="card-body px-3 py-5">
                                <h2 class="fw-bold text-uppercase text-center fs-18">Admin Login</h2>
                                <p class="text-muted text-center mt-1 mb-4 <?= $error ? 'text-danger' : 'text-success' ?>"> <?= $error ?? '' ?></p>

                                <div class="px-4">
                                    <form class="authentication-form" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email">Username or Email</label>
                                            <input type="text" id="example-email" name="username" class="form-control bg-light bg-opacity-50 border-light py-2" placeholder="Username or email" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password">Password</label>
                                            <input type="password" name="password" id="example-password" class="form-control bg-light bg-opacity-50 border-light py-2" placeholder="Password" required/>
                                        </div>

                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-danger py-2 fw-medium" type="submit" name="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </div>

        <!-- Vendor Javascript (Require in all Page) -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App Javascript (Require in all Page) -->
        <script src="assets/js/app.min.js"></script>
    </body>

</html>