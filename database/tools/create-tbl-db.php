<?php

    try {
        // SQL to create users table
        $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            -- id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            pass_encrypt VARCHAR(250) NOT NULL,
            verification_code VARCHAR(250) NOT NULL,
            sec_verification_code VARCHAR(250) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            clock_in DATETIME DEFAULT CURRENT_TIMESTAMP,
            clock_out DATETIME DEFAULT CURRENT_TIMESTAMP,
            prof_pic VARCHAR(250) NULL
        )";

        // SQL to create priority table
        $sqlPriority = "CREATE TABLE IF NOT EXISTS priority (
            id INTEGER PRIMARY KEY,
            name_doc VARCHAR(100) NOT NULL,
            pdf TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";

        // Create main database connection
        $db = new PDO('sqlite:../main/PassViewer.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create tables in main database
        $db->exec($sqlUsers);
        $db->exec($sqlPriority);

        // Create backup database connection
        $dbBackup = new PDO('sqlite:../backup/PassViewer.db');
        $dbBackup->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create tables in backup database
        $dbBackup->exec($sqlUsers);
        $dbBackup->exec($sqlPriority);

        echo "Tables created successfully in both databases!";

    } catch (PDOException $e) {
        // Catch any exceptions and display the error message
        echo "Error creating tables: " . $e->getMessage();
    }

?>
