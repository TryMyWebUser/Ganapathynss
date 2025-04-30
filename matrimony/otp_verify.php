<?php
    include "../libs/load.php";

    // Start session and get user info
    Session::start();
    $user = Operations::getUser();
    
    $emailToShow = $user['email'] ?? Session::get('login_user') ?? header('Location: index.php');

    // Redirect verified users
    if (Session::get('login_user') && $user['status'] === 'verified') {
        header('Location: index.php');
        exit;
    }

    // Initialize variables
    $success = "";
    $error = "";

    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Combine OTP inputs
        function getFullOTP()
        {
            $otp = '';
            for ($i = 0; $i < 6; $i++) {
                $otp .= $_POST["otp_$i"] ?? '';
            }
            return $otp;
        }

        $email = $emailToShow;

        $otp = getFullOTP();
        if ($otp && $email) {
            $result = User::verifyOTP($email, $otp);
            if ($result === true) {
                Session::regenerate();
                Session::set("login_user", $email);
                header("Location: welcome.php");
                exit;
            } else {
                $error = $result;
            }
        }

        if (isset($_POST['resend']) && $email) {
            $resend = User::resendOTP($email);
            $success = $resend === true ? "A new OTP has been sent to your email." : $resend;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>OTP Verification</title>
        <!-- favicons Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicons/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicons/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicons/favicon-16x16.png" />
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

            body {
                font-family: "Poppins", sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #121212;
                color: #e0e0e0;
                background-image: radial-gradient(circle at 25% 25%, rgba(166, 86, 246, 0.1) 2%, transparent 0%), radial-gradient(circle at 75% 75%, rgba(102, 101, 241, 0.1) 2%, transparent 0%);
                background-size: 60px 60px;
            }
            .container {
                background-color: rgba(30, 30, 30, 0.8);
                padding: 3rem;
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                text-align: center;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                max-width: 400px;
                width: 100%;
            }
            h1 {
                margin-bottom: 1.5rem;
                color: #ffffff;
                font-weight: 600;
                font-size: 2rem;
            }
            p {
                margin-bottom: 2rem;
                color: #b0b0b0;
                font-weight: 300;
            }
            .otp-input {
                display: flex;
                justify-content: center;
                margin-bottom: 2rem;
            }
            .otp-input input {
                width: 50px;
                height: 50px;
                margin: 0 8px;
                text-align: center;
                font-size: 1.5rem;
                border: 2px solid #6665f1;
                border-radius: 12px;
                background-color: rgba(42, 42, 42, 0.8);
                color: #ffffff;
                transition: all 0.3s ease;
            }
            .otp-input input:focus {
                border-color: #a556f6;
                box-shadow: 0 0 0 2px rgba(166, 86, 246, 0.3);
                outline: none;
            }
            .otp-input input::-webkit-outer-spin-button,
            .otp-input input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            .otp-input input[type="number"] {
                -moz-appearance: textfield;
            }
            button#valid {
                background: linear-gradient(135deg, #6665f1, #a556f6);
                color: white;
                border: 2px solid #6665f1;
                padding: 12px 24px;
                font-size: 1rem;
                border-radius: 8px;
                cursor: pointer;
                margin: 5px;
                transition: all 0.3s ease;
                font-weight: 500;
                letter-spacing: 0.5px;
            }
            button:hover {
                background: linear-gradient(135deg, #a556f6, #6665f1);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(166, 86, 246, 0.3);
            }
            button:disabled {
                background: #cccccc;
                border-color: #999999;
                color: #666666;
                cursor: not-allowed;
                transform: none;
                box-shadow: none;
            }
            #timer {
                font-size: 1rem;
                color: #a556f6;
                font-weight: 500;
                margin-left: 10px;
            }
            @keyframes pulse {
                0% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.5;
                }
                100% {
                    opacity: 1;
                }
            }
            .expired {
                animation: pulse 2s infinite;
                color: #ff4444;
            }
            .resend-text {
                margin-top: 1rem;
                font-size: 0.9rem;
                color: #b0b0b0;
            }
            .resend-link {
                color: #6665f1;
                text-decoration: none;
                cursor: pointer;
                transition: color 0.3s ease;
            }
            .resend-link:hover {
                color: #a556f6;
                text-decoration: underline;
                box-shadow: none;
            }
            #email {
                color: #a556f6;
                font-weight: 500;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>OTP Verification</h1>
            <p>Enter the OTP you received to <span id="email"><?= $emailToShow ?></span></p>
            
            <?php if ($error): ?>
                <p class="text-danger text-15 mb-32"><?= $error ?></p>
            <?php elseif ($success): ?>
                <p class="text-success text-15 mb-32"><?= $success ?></p>
            <?php endif; ?>

            <form id="verify" method="POST">
                <input type="hidden" name="email" value="<?= htmlspecialchars($emailToShow) ?>">
                <div class="otp-input">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <input type="number" name="otp_<?= $i ?>" class="squire-input" min="0" max="9" required>
                    <?php endfor; ?>
                </div>
                <button type="submit" name="verify" id="valid" class="btn btn-main rounded-pill w-100">Verify Now</button>
            </form>
            <form class="resend-text" method="POST">
                <p class="text-gray-600 text-center">
                    Wait for <span id="countdown">30</span> seconds to resend OTP.
                </p>

                <span>
                    <button type="submit" id="resendBtn" name="resend" class="resend-link" style="display: none; background: unset; border: unset; font-size: 16px;">
                        Resend OTP
                    </button>
                </span>
            </form>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var countdownTime = 30;
                var countdownElement = document.getElementById("countdown");
                var resendButton = document.getElementById("resendBtn");

                var countdownInterval = setInterval(function() {
                    countdownTime--;
                    countdownElement.textContent = countdownTime;

                    if (countdownTime <= 0) {
                        clearInterval(countdownInterval);
                        countdownElement.parentElement.style.display = "none"; // hide the "Wait for X seconds" text
                        resendButton.style.display = "inline-block"; // show the resend button
                    }
                }, 1000);
            });

            document.addEventListener("DOMContentLoaded", function() {
                const inputs = document.querySelectorAll('.squire-input');
                const form = document.querySelector('form#verify');
                const valid = document.querySelector('#valid');

                function collectOTP() {
                    let otp = '';
                    inputs.forEach(input => {
                        otp += input.value.trim();
                    });
                    return otp;
                }

                function checkAndSubmitOTP() {
                    const fullOTP = collectOTP();
                    if (fullOTP.length === 6) {
                        if (valid) {
                            valid.innerHTML = "Verifying...";
                            valid.disabled = true;
                        }
                        inputs.forEach(inp => inp.readOnly = true); // make inputs readonly
                        form.submit();
                    }
                }

                inputs.forEach((input, index) => {
                    input.addEventListener('input', (e) => {
                        if (e.target.value.length > 1) {
                            e.target.value = e.target.value.slice(0, 1); // only allow 1 number
                        }
                        if (e.target.value && index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                        checkAndSubmitOTP(); // always check after every input
                    });

                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Backspace' && !e.target.value) {
                            if (index > 0) {
                                inputs[index - 1].focus();
                            }
                        }
                        if (e.key === 'e' || e.key === '+' || e.key === '-' || e.key === '.') {
                            e.preventDefault(); // prevent unwanted keys in number input
                        }
                    });
                });
            });
        </script>
    </body>
</html>