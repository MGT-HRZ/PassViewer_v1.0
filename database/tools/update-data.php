<?php

    try {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        // Prepare your update data
        $id = 0; // Manually specified ID (ensure this ID is unique)
        $name = ""; // Example name
        $email = "@gmail.com"; // Example email
        $pass_encrypt = md5(md5(md5(''))); // Example encrypted password
        $verification_code = md5(md5(md5(''))); // Example unique verification code
        $sec_verification_code = "-"; // Example unique secondary verification code

        // Function to update user data in the database
        function updateUserData($db, $sqlUpdate, $id, $name, $email, $pass_encrypt, $verification_code, $sec_verification_code) {
            $stmt = $db->prepare($sqlUpdate);

            // Bind parameters
            $stmt->bindParam(':id', $id); 
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass_encrypt', $pass_encrypt);
            $stmt->bindParam(':verification_code', $verification_code);
            $stmt->bindParam(':sec_verification_code', $sec_verification_code);

            // Execute the query
            $stmt->execute();
        }

        // Update query for the databases
        $sqlUpdate = "UPDATE users 
                    SET name = :name, email = :email, pass_encrypt = :pass_encrypt, 
                        verification_code = :verification_code, sec_verification_code = :sec_verification_code
                    WHERE id = :id";

        // Connect to the main database
        $db = new PDO('sqlite:../main/PassViewer.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Update data in the main database
        updateUserData($db, $sqlUpdate, $id, $name, $email, $pass_encrypt, $verification_code, $sec_verification_code);

        // Now, connect to the backup database
        $dbBackup = new PDO('sqlite:../backup/PassViewer.db');
        $dbBackup->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update data in the backup database
        updateUserData($dbBackup, $sqlUpdate, $id, $name, $email, $pass_encrypt, $verification_code, $sec_verification_code);

        echo "User updated in both databases successfully!<br>";
        echo "Updated User ID: " . $id . "<br>";

    } catch (PDOException $e) {
        // Catch any exceptions and display the error message
        echo "Error updating data: " . $e->getMessage();
    }

?>
