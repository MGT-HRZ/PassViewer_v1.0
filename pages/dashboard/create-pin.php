<?php

    session_start();

    include_once "../../config/config.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_SESSION['user_email'];
        $pin = md5(md5(md5($_POST['pin'])));

        try {
            // Connect to the SQLite database
            $db = new PDO('sqlite:../../database/main/PassViewer.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL query to insert the PIN and unlock_id into the users table
            $stmt = $db->prepare("UPDATE users SET sec_verification_code = :pin WHERE email = :email AND id = :id");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':pin', $pin, PDO::PARAM_STR);
            // Execute the query
            $stmt->execute();

            // Check if any row was updated (if the user exists and the PIN was set successfully)
            if ($stmt->rowCount() > 0) {
                // PIN successfully inserted/updated
                header("Location: dashboard.php?unlock-completed");
                exit();
            } else {
                // No user found or the PIN was not updated
                header("Location: dashboard.php?problem");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

?>
