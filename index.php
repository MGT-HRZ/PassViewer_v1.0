<?php

    include_once "config/config.php";

    // Here, we query the database to see if the user has signed up before
    try {
        $db = new PDO('sqlite:database/main/PassViewer.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to check if any users exist with ID = 1 (since you only want user with ID = 1)
        $sql = "SELECT id FROM users WHERE id = $TARGET_ID OR id = $TARGET_ID2";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        // Fetch the user with ID = 1
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the user exists (meaning someone has already signed up), redirect to signin.php
        if ($user) {
            header('Location: pages/signin/signin.php');
        }

        // Otherwise, redirect to signup.php if no users are found
        else {
            header('Location: pages/email/verify-email.php');
        }

    } catch (PDOException $e) {
        // Catch any exceptions and display the error message
        echo "Error reading data: " . $e->getMessage() . "\n";
    }

?>
