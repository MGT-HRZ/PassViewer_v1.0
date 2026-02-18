<?php

    session_start();

    include_once "../../config/config.php";
    include_once "../../tools/genRandStrg.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_SESSION['user_email'];
        $pin = md5(md5(md5($_POST['pin'])));

        try {
            // Connect to the SQLite database
            $db = new PDO('sqlite:../../database/main/PassViewer.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL query
            $stmt = $db->prepare("SELECT id, sec_verification_code FROM users WHERE email = :email AND id = :id");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $unlock_id = md5(password_hash(generateRandomString(20), PASSWORD_DEFAULT));

            if ($user) {
                // Verify the password
                if ($pin === $user['sec_verification_code']) {
                    $_SESSION['unlock_id'] = $unlock_id;
                    header("Location: dashboard.php?unlock=" . $unlock_id);

                    exit();
                } else {
                    // Invalid password
                    // echo "<script>alert('Invalid pin! Please try again.');</script>";
                    header("Location: dashboard.php?problem-verify-pin");
                }
            } else {
                // No user found with this email
                header("Location: dashboard.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
