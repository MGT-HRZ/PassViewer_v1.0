<?php

    try {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        // Prepare your insert data
        $id = 0; // Manually specified ID (ensure this ID is unique)
        $name = ""; // Example name
        $email = "@gmail.com"; // Example email
        $pass_encrypt = md5(md5(md5(''))); // Example encrypted password
        $verification_code = md5(md5(md5(''))); // Example unique verification code
        $sec_verification_code = "-"; // Example unique secondary verification code

        // Function to insert data into the database
        function insertUserData($db, $sqlInsert, $id, $name, $email, $pass_encrypt, $verification_code, $sec_verification_code) {
            $stmt = $db->prepare($sqlInsert);

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

        // Insert query for the databases
        $sqlInsert = "INSERT INTO users (id, name, email, pass_encrypt, verification_code, sec_verification_code) 
                        VALUES (:id, :name, :email, :pass_encrypt, :verification_code, :sec_verification_code)";

        // Connect to the main database
        $db = new PDO('sqlite:../main/PassViewer.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Insert data into the main database
        insertUserData($db, $sqlInsert, $id, $name, $email, $pass_encrypt, $verification_code, $sec_verification_code);

        echo "\nUser added to both databases successfully!\n\n";
        echo "Manually assigned User ID: " . $id . "\n";

    } catch (PDOException $e) {
        // Catch any exceptions and display the error message
        echo "Error inserting data: " . $e->getMessage();
    }

?>
