<?php

    try {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        // Prepare your delete data
        $id = 0; // Manually specified ID (ensure this ID exists in the database)

        // Function to delete user data from the database
        function deleteUserData($db, $sqlDelete, $id) {
            $stmt = $db->prepare($sqlDelete);

            // Bind parameters
            $stmt->bindParam(':id', $id);

            // Execute the query
            $stmt->execute();
        }

        // Delete query for the databases
        $sqlDelete = "DELETE FROM users WHERE id = :id";

        // Connect to the main database
        $db = new PDO('sqlite:../main/PassViewer.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Delete data from the main database
        deleteUserData($db, $sqlDelete, $id);

        // Now, connect to the backup database
        $dbBackup = new PDO('sqlite:../backup/PassViewer.db');
        $dbBackup->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete data from the backup database
        deleteUserData($dbBackup, $sqlDelete, $id);

        echo "User deleted from both databases successfully!<br>";
        echo "Deleted User ID: " . $id . "<br>";

    } catch (PDOException $e) {
        // Catch any exceptions and display the error message
        echo "Error deleting data: " . $e->getMessage();
    }

?>
