<?php

    // Path to the SQLite database file
    $dbPath = '../main/PassViewer.db';
    $dbPathBackup = '../backup/PassViewer.db';

    // Create or open the SQLite database
    $db = new SQLite3($dbPath);
    $dbBackup = new SQLite3($dbPathBackup);

    // Check if the database was successfully created
    if ($db && $dbBackup) {
        echo "Database created successfully.\n";
    } else {
        echo "Failed to create the database.\n";
    }

    // Close the database connection
    $db->close();

?>
