<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

class User
{
    public $conn = null;

    public static function register($name, $gender, $dob, $phone, $email, $hashed_password, $religion, $caste, $mother_tongue, $sub_caste, $profile_created_by, $profile_img)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/Users/";

        // Ensure directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $allowImageTypes = ['jpg', 'png', 'jpeg', 'gif'];
        $filePath = null;

        // Handle profile image upload
        if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_img'];
            $filename = basename($file['name']);
            $filePath = $targetDir . uniqid() . "_" . $filename;
            $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowImageTypes)) {
                return "Invalid image format. Only JPG, PNG, JPEG, GIF allowed.";
            }

            if (!move_uploaded_file($file["tmp_name"], $filePath)) {
                return "Failed to upload profile image.";
            }
        }

        try {
            // Use EXACT column names from your database
            $sql = "INSERT INTO `users` 
                    (`name`, `gender`, `dob`, `phone`, `email`, `password`, `religion`, `caste`, `mother_tongue`, `sub_caste`, `profile_created_by`, `profile_img`, `otp`, `otp_expiry`, `status`, `payment` `created_at`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            // Bind parameters - must match EXACTLY with the column order above
            $otp = NULL;
            $otp_expiry = NULL;
            $status = 'not';
            $pay = 'not';

            $stmt->bind_param("ssssssssssssssss", $name, $gender, $dob, $phone, $email, $hashed_password, $religion, $caste, $mother_tongue, $sub_caste, $profile_created_by, $filePath, $otp, $otp_expiry, $status, $pay);

            if ($stmt->execute()) {
                Session::regenerate();
                Session::set('login_user', $name);
                header("Location: otp_verify.php");
                exit;
            } else {
                throw new Exception("Error inserting user data: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }
    public static function updateProfile($userId, $name, $gender, $dob, $phone, $email, $hashed_password, $religion, $caste, $mother_tongue, $sub_caste, $profile_created_by, $profile_img)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/Users/";

        // Ensure directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $allowImageTypes = ['jpg', 'png', 'jpeg', 'gif'];
        $filePath = null;

        // Fetch current profile image for unlinking
        $currentImage = null;
        $imageQuery = $conn->prepare("SELECT profile_img FROM users WHERE id = ?");
        $imageQuery->bind_param("i", $userId);
        $imageQuery->execute();
        $imageQuery->bind_result($currentImage);
        $imageQuery->fetch();
        $imageQuery->close();

        // Handle optional profile image upload
        if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_img'];
            $filename = basename($file['name']);
            $filePath = $targetDir . uniqid() . "_" . $filename;
            $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowImageTypes)) {
                return "Invalid image format. Only JPG, PNG, JPEG, GIF allowed.";
            }

            if (!move_uploaded_file($file["tmp_name"], $filePath)) {
                return "Failed to upload profile image.";
            }

            // Delete old image if exists
            if (!empty($currentImage) && file_exists($currentImage)) {
                unlink($currentImage);
            }
        }

        try {
            // Build base query
            $sql = "UPDATE users SET 
                        name = ?, 
                        gender = ?, 
                        dob = ?, 
                        phone = ?, 
                        email = ?, 
                        religion = ?, 
                        caste = ?, 
                        mother_tongue = ?, 
                        sub_caste = ?, 
                        profile_created_by = ?";

            $params = [$name, $gender, $dob, $phone, $email, $religion, $caste, $mother_tongue, $sub_caste, $profile_created_by];
            $types = "ssssssssss";

            // If password is provided
            if (!empty($hashed_password)) {
                $sql .= ", password = ?";
                $params[] = $hashed_password;
                $types .= "s";
            }

            // If image is uploaded
            if ($filePath !== null) {
                $sql .= ", profile_img = ?";
                $params[] = $filePath;
                $types .= "s";
            }

            // Finalize query
            $sql .= " WHERE id = ?";
            $params[] = $userId;
            $types .= "i";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                header("Location: profile.php?username=" . $name);
                exit;
            } else {
                throw new Exception("Error updating user data: " . $stmt->error);
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }

    public static function login($username, $password)
    {
        Session::start();
        $conn = Database::getConnect();
        
        $sql = "SELECT `id`, `password` FROM `users` WHERE `name` = '$username' OR `email` = '$username' OR `phone` = '$username'";
        // die($sql);
        $res = $conn->query($sql);
        if ($res->num_rows === 1)
        {
            $row = $res->fetch_assoc();
            if (password_verify($password, $row['password']))
            {
                Session::regenerate();
                Session::set('login_user', $username);
                header("Location: otp_verify.php");
                exit;
            }
        }

        return "Invalid Username and Password";
    }

    // Function to send OTP email using PHPMailer
    public static function sendOTP($email, $otp)
    {
        $mail = new PHPMailer(true);

        Session::start();
        Session::regenerate();
        Session::set("login_user", $email);  // Store email in session

        try {
            // SMTP configuration
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'trymywebsites@gmail.com'; // Your email address
            $mail->Password = 'nmhw uxqv vvpl fbvp'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email setup
            $mail->setFrom('trymywebsites@gmail.com', 'Ganapathy NSS - Matrimony'); // Sender's email and name
            $mail->addAddress($email); // Add recipient email
            $mail->Subject = 'Verification Code';
            $mail->Body = "<div style='background:rgb(255, 255, 255);'>
                                <div class='container' style='max-width: 600px; margin: 20px auto; background: #FFF; border-radius: 8px; overflow: hidden; padding: 32px 16px; text-align: center;'>
                                    <div class='logo'>
                                        <!-- <img src='Domain/assets/img/logo.jpg' style='background: #FFF; border-radius: 1rem; width: 280px; height: auto;' alt='Logo' /> -->
                                        <!-- assets/images/logo/logo.png -->                                    
                                    </div>

                                    <h1 style='font-size: 24px; margin: 20px 0 10px;'>Please confirm your email</h1>
                                    <p style='font-size: 16px; margin: 10px 0; color: #555;'>Use this code to confirm your email and complete register.</p>

                                    <div class='otp-box' style='background:rgb(0, 102, 255); margin: 20px auto; display: inline-block; padding: 16px 24px; border-radius: 8px; font-size: 32px; font-weight: bold; color: #FFF;'>
                                        {$otp}
                                    </div>

                                    <p style='font-size: 16px; margin: 10px 0; color: #555;'>
                                        This code is valid for 5 minutes.
                                    </p>
                                </div>
                            </div>";
            $mail->isHTML(true); // Set to plain text

            // At the start of your script, enable output buffering if necessary
            ob_start();

            // Your PHPMailer code
            $mail->SMTPDebug = 0; // Disable SMTP debugging output

            // Send email
            if ($mail->send()) {
                return true;
            } else {
                echo "PHPMailer Error: " . $mail->ErrorInfo;
                return false;
            }

            // At the end of the script, flush the buffer if needed
            ob_end_flush();
        } catch (Exception $e) {
            print_r("PHPMailer Exception: " . $e->getMessage());
            return false;
        }
    }

    // Function to verify OTP and handle expiry logic
    public static function verifyOTP($email, $otp)
    {
        $conn = Database::getConnect();
        $query = "SELECT `otp`, `otp_expiry`, `status` FROM `users` WHERE `email` = '$email' OR `name` = '$email' OR `phone` = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $dbtime = $row['otp_expiry'];
            $expiryTimestamp = strtotime($dbtime);
            if ($expiryTimestamp === false) {
                return "Invalid or expired OTP.";
            }

            if ($row['otp'] == trim($otp) && $expiryTimestamp >= time()) {
                $conn->query("UPDATE `users` SET `otp` = NULL, `otp_expiry` = NULL, `status` = 'verified' WHERE `email` = '$email' OR `name` = '$email' OR `phone` = '$email'");
                return true;
            } else {
                return "Invalid or expired OTP.";
            }
        } else {
            return "User not found.";
        }
    }

    // Function to handle OTP resend
    public static function resendOTP($email)
    {
        $conn = Database::getConnect();
        $query = "SELECT `otp`, `otp_expiry` FROM `users` WHERE `email` = '$email' OR `name` = '$email' OR `phone` = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Check if OTP can be resent (only after expiry or 60 seconds have passed)
            $expiryTimestamp = strtotime($row['otp_expiry']);
            if ((string)$expiryTimestamp < time()) {
                // OTP has expired, generate a new OTP
                $otp = random_int(100000, 999999);
                $otp = (String)$otp;
                $otpExpiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                $conn->query("UPDATE `users` SET `otp` = '$otp', `otp_expiry` = '$otpExpiry' WHERE `email` = '$email' OR `name` = '$email' OR `phone` = '$email'");
                
                // Send the new OTP
                if (User::sendOTP($email, $otp)) {
                    return true;
                } else {
                    return "Error sending OTP.";
                }
            } else {
                return "You can resend the OTP after it expires.";
            }
        } else {
            return "User not found.";
        }
    }

    // public static function setCategory($page, $cate)
    // {
    //     $conn = Database::getConnect();

    //     // Insert data into database
    //     $sql = "INSERT INTO `category` (`page`, `category`, `created_at`)
    //             VALUES ('$page', '$cate', NOW())";

    //     if ($conn->query($sql)) {
    //         header("Location: viewCate.php");
    //         exit;
    //     } else {
    //         return "Error occurred while saving data: " . $conn->error;
    //     }
    // }
    // public static function updateCategory($getID, $page, $cate, $conn)
    // {
    //     // Update data into database
    //     $sql = "UPDATE `category` SET `page` = '$page', `category` = '$cate', `created_at` = NOW() WHERE `id` = '$getID'";

    //     if ($conn->query($sql)) {
    //         header("Location: viewCate.php");
    //         exit;
    //     } else {
    //         return "Error occurred while saving data: " . $conn->error;
    //     }
    // }

    // public static function setProducts($title, $dec, $img, $cate)
    // {
    //     $conn = Database::getConnect();
    //     $targetDir = "../uploads/Products/"; // Define your upload directory
        
    //     if (!is_dir($targetDir)) {
    //         // Create directory with proper permissions
    //         mkdir($targetDir, 0777, true);
    //     }

    //     $allowImageTypes = ['jpg', 'png', 'jpeg', 'gif'];

    //     // Required file uploads
    //     $requiredFiles = [
    //         'img' => $_FILES["img"]
    //     ];

    //     foreach ($requiredFiles as $key => $file) {
    //         $fileName = basename($file["name"]);
    //         $filePath = $targetDir . $fileName;
    //         $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            
    //         if (!in_array($fileType, $allowImageTypes) || !move_uploaded_file($file["tmp_name"], $filePath)) {
    //             return "Error uploading required file: $key.";
    //         }
    //         $$key = $filePath; // Dynamically assign variable with directory
    //     }

    //     // Insert data into database
    //     $sql = "INSERT INTO `products` (`img`, `title`, `dec`, `category`, `created_at`) 
    //             VALUES ('$filePath', '$title', '$dec', '$cate', NOW())";

    //     if ($conn->query($sql)) {
    //         header("Location: viewProduct.php");
    //         exit;
    //     } else {
    //         return "Error occurred while saving data: " . $conn->error;
    //     }
    // }
    // public static function updateProducts($title, $dec, $img, $cate, $getID, $conn)
    // {
    //     $targetDir = "../uploads/Products/"; // Define your upload directory
        
    //     if (!is_dir($targetDir)) {
    //         // Create directory with proper permissions
    //         mkdir($targetDir, 0777, true);
    //     }

    //     $qry = $conn->query("SELECT * FROM `products` WHERE `id` = '$getID'")->fetch_array();

    //     $allowImageTypes = ['jpg', 'png', 'jpeg', 'gif'];

    //     // Check if a file was uploaded
    //     if (!empty($_FILES["img"]["name"])) {
    //         $fileName = basename($_FILES["img"]["name"]);
    //         $filePath = $targetDir . $fileName;
    //         $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    //         // Validate file type
    //         if (!in_array($fileType, $allowImageTypes)) {
    //             return "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
    //         }

    //         // Validate file size (e.g., 5MB max)
    //         if ($_FILES["img"]["size"] > 5 * 1024 * 1024) {
    //             return "Error: File size exceeds the maximum limit of 5MB.";
    //         }

    //         // Move uploaded file to target directory
    //         if (!move_uploaded_file($_FILES["img"]["tmp_name"], $filePath)) {
    //             return "Error: Failed to upload file.";
    //         }

    //         // Delete old image if it exists
    //         if (!empty($qry['img']) && file_exists($qry['img'])) {
    //             unlink($qry['img']);
    //         }

    //         // Update database with new image path
    //         $sql = "UPDATE `products` SET `img` = ?, `title` = ?, `dec` = ?, `category` = ?, `created_at` = NOW() WHERE `id` = ?";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("ssssi", $filePath, $title, $dec, $cate, $getID);
    //     } else {
    //         // Update database without changing the image
    //         $sql = "UPDATE `products` SET `title` = ?, `dec` = ?, `category` = ?, `created_at` = NOW() WHERE `id` = ?";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("sssi", $title, $dec, $cate, $getID);
    //     }

    //     // Execute the statement
    //     if ($stmt->execute()) {
    //         header("Location: viewProduct.php");
    //         exit;
    //     } else {
    //         return "Error occurred while saving data: " . $stmt->error;
    //     }
    // }
}

?>