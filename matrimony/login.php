<?php
include "../libs/load.php"; // Include your setup file

Session::start();
$user = Operations::getUser();

if (Session::get('login_user')) {
    header("Location: welcome.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $error = User::login($username, $password);
    }
}
?>

<?php include "header.php" ?>

<!-- main-slider-start -->
<section class="main-slider-one mt-5" style="padding: 8rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-black">
                        <h4 class="mb-0">Login to Your Account</h4>
                    </div>
                    
                    <div class="card-body">
                        <?php if (isset($login_error)): ?>
                            <div class="alert alert-danger"><?php echo $login_error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" id="loginForm" class="needs-validation" novalidate>
                            <div class="form-group">
                                <label for="loginEmail" class="form-label">Name or Email or Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="loginEmail" name="username" 
                                       placeholder="Enter Your Name or Email or Phone " required>
                            </div>
                            
                            <div class="form-group">
                                <label for="loginPassword" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="loginPassword" name="password" 
                                       placeholder="Enter Your Password" required>
                                <div class="invalid-feedback">Please enter your password.</div>
                            </div>
                            
                            <div class="form-group text-center mt-3">
                                <button type="submit" name="submit" class="btn btn-outline-primary">Login</button>
                            </div>
                        </form>
                        
                        <hr>
                        
                        <div class="text-center d-flex">
                            <p class="mb-2">Don't have an account?</p>
                            <a href="index.php" class="text-primary ms-2">Register Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php" ?>

<script>
    // Form validation
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            // Get the form we want to add validation to
            var form = document.getElementById('loginForm');

            // Form submission validation
            form.addEventListener('submit', function(event) {
                // Reset validation state
                form.classList.remove('was-validated');
                
                // Check form validity
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();
</script>