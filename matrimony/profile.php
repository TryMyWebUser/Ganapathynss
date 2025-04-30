<?php
include "../libs/load.php";

Session::start();
$us = Operations::getUser();
$user = Operations::targetUser();
if (!Session::get('login_user')) {
    header("Location: welcome.php");
    exit;
} elseif ($user['status'] === 'not') {
    header("Location: otp_verify.php");
    exit;
}elseif ($user['payment'] === 'not' && $us['name'] != $user['name']) {
    header("Location: pay.php");
    exit;
} elseif (!$_GET['username']) {
    header("Location: index.php");
    exit;
}

include "header.php";
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 2px solid #03b1ce;
        object-fit: cover;
        cursor: pointer;
    }

    .profile-info-label {
        font-weight: 500;
        color: #555;
    }

    .profile-section {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .profile-row {
        margin-bottom: 15px;
    }

    input.hidden {
        position: absolute;
        left: -9999px;
    }
</style>

<section style="min-height: 80vh; background-color: #f4f4f4; padding: 10rem 0 5rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-section">
                    <div class="text-center mb-4">
                        <img src="<?= $user['profile_img'] ?>" alt="Profile Image" class="profile-image" id="profile-image1">
                        <h4 class="mt-3"><?= htmlspecialchars($user['name']) ?></h4>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Gender:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['gender']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Date of Birth:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['dob']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Phone:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['phone']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Email:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['email']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Religion:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['religion']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Caste:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['caste']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Sub Caste:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['sub_caste']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Mother Tongue:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['mother_tongue']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Profile Created By:</div>
                        <div class="col-sm-7"><?= htmlspecialchars($user['profile_created_by']) ?></div>
                    </div>

                    <div class="row profile-row">
                        <div class="col-sm-5 profile-info-label">Joined Date:</div>
                        <div class="col-sm-7"><?= date('d M Y', strtotime($user['created_at'])) ?></div>
                    </div>

                    <?php if ($user['name'] === $us['name']) { ?>
                    <div class="text-center mt-4">
                        <a href="edit_profile.php?id=<?= $user['id'] ?>" class="btn btn-primary px-4">Edit Profile</a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
