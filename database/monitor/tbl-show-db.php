<?php

    // Connect to SQLite database
    try {
        $db = new PDO('sqlite:../main/PassViewer.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to select all users from the table
        $sqlUsers = "SELECT * FROM users";
        $stmtUsers = $db->prepare($sqlUsers);
        $stmtUsers->execute();

        // Fetch all user records as an associative array
        $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

        // Check if any users are found
        if ($users) {
            echo "\n=== Users Data ===\n\n";
            foreach ($users as $user) {
                echo "ID: " . $user['id'] . "\n";
                echo "Name: " . $user['name'] . "\n";
                echo "Email: " . $user['email'] . "\n";
                echo "Password Encryption: " . $user['pass_encrypt'] . "\n";
                echo "Verification Code: " . $user['verification_code'] . "\n";
                echo "2nd Verification Code: " . $user['sec_verification_code'] . "\n";
                echo "Created At: " . $user['created_at'] . "\n";
                echo "Clock In: " . $user['clock_in'] . "\n";
                echo "Clock Out: " . $user['clock_out'] . "\n";
                echo "Profile Pic: " . $user['clock_out'] . "\n\n";
            }
        } else {
            echo "\nNo users found in the database.\n\n";
        }

        // Divider between users and priority data
        echo str_repeat("-", 40) . "\n\n";  // Divider line

        // Query to select all records from the priority table
        $sqlPriority = "SELECT * FROM priority";
        $stmtPriority = $db->prepare($sqlPriority);
        $stmtPriority->execute();

        // Fetch all priority records as an associative array
        $priority = $stmtPriority->fetchAll(PDO::FETCH_ASSOC);

        // Check if any priority records are found
        if ($priority) {
            echo "=== Priority Data ===\n\n";
            foreach ($priority as $item) {
                echo "ID: " . $item['id'] . "\n";
                echo "Document Name: " . $item['name_doc'] . "\n";
                echo "PDF: " . substr($item['pdf'], 0, 100) . "...\n";  // Display only the first 100 characters of the base64 string
                echo "Created At: " . $item['created_at'] . "\n\n";
            }
        } else {
            echo "No priority records found in the database.\n";
        }

    } catch (PDOException $e) {
        // Catch any exceptions and display the error message
        echo "Error reading data: " . $e->getMessage() . "\n";
    }

?>
