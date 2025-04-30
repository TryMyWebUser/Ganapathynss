<?php
include "../libs/load.php";

Session::start();
$user = Operations::getUser();
if (!Session::get('login_user')) {
    header("Location: welcome.php");
    exit;
} elseif ($user['status'] === 'not') {
    header("Location: otp_verify.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon-32x32.png" />

        <title>QR code</title>
        <style>
            body {
                font-family: "Outfit", sans-serif;
                background-color: hsl(212, 45%, 89%);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .qr-code-payment {
                padding: 20px;
                flex-direction: column;
                display: flex;
                align-items: center;
                background-color: hsl(0, 0%, 100%);
                width: 300px;
                /* height: 480px; */
                border-radius: 20px;
                box-shadow: 50px;
            }

            .header {
                font-size: 12px;
                text-align: center;
            }
            .paragraph {
                font-size: 15px;
                color: hsl(220, 15%, 55%);
                text-align: center;
            }
            .footer {
                padding: 15px;
            }
        </style>
    </head>

    <body>
        <div class="qr-code-payment">
            <div class="image-qr-code">
                <img style="border-radius: 20px;" src="assets/img/image-qr-code.png" alt="image-qr-code" width="300px" height="300px" />
            </div>

            <div class="header">
                <h1>
                    Pay Now<br />
                    Send Screenshot Via Whatsapp 
                </h1>

                <style>
                    .whatsapp-btn {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        background-color: #25D366;
                        color: white;
                        padding: 12px 24px;
                        border-radius: 50px;
                        text-decoration: none;
                        font-weight: 600;
                        font-family: 'Segoe UI', sans-serif;
                        font-size: 16px;
                        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
                        transition: all 0.3s ease;
                        border: none;
                        cursor: pointer;
                        gap: 8px;
                    }
    
                    .whatsapp-btn:hover {
                        background-color: #128C7E;
                        transform: translateY(-2px);
                        box-shadow: 0 6px 16px rgba(37, 211, 102, 0.4);
                    }
    
                    .whatsapp-btn:active {
                        transform: translateY(0);
                        box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
                    }
    
                    .whatsapp-icon {
                        font-size: 20px;
                    }
                </style>
    
                <a href="https://wa.me/9897649480/" class="whatsapp-btn">
                    <i class="fab fa-whatsapp whatsapp-icon"></i>
                    Chat on WhatsApp
                </a>

                <!-- Font Awesome for icons -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            </div>

            <div class="paragraph">
                <p>
                    <br><a href="index.php">Go Back</a>
                </p>
            </div>
        </div>
    </body>
</html>