<?php

    include "../libs/load.php";

    // Start a session
    Session::start();

    if (!Session::get('login_user'))
    {
        header("Location: index.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <?php include "temp/head.php" ?>

    </head>

    <body>
        <!-- START Wrapper -->
        <div class="wrapper">
            <!-- ========== Topbar Start ========== -->
            <?php include "temp/header.php" ?>

            <!-- Right Sidebar (Theme Settings) -->
            <?php include "temp/sideheader.php" ?>
            <!-- ========== App Menu End ========== -->

            <!-- ==================================================== -->
            <!-- Start right Content here -->
            <!-- ==================================================== -->
            <div class="page-content">
                <!-- Start Container Fluid -->
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between my-4 page-header-breadcrumb flex-wrap gap-2">
                        <div>
                            <p class="fw-medium fs-20 mb-0">Welcome, Admin.</p>
                            <p class="fs-13 text-muted mb-0">Here's what's happening with your store today.</p>
                        </div>
                    </div>
                </div>
                <!-- End Container Fluid -->

                <?php include "temp/footer.php" ?>

            </div>
            <!-- ==================================================== -->
            <!-- End Page Content -->
            <!-- ==================================================== -->
        </div>
        <!-- END Wrapper -->

    </body>

</html>