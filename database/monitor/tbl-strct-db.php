<?php

    // Connect to SQLite
    $db = new PDO('sqlite:../main/PassViewer.db');

    try {
        // Describe the 'users' table
        $stmt = $db->query("PRAGMA table_info(users)");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display table information for 'users'
        foreach ($columns as $column) {
            echo "Column ID: {$column['cid']}\n";
            echo "Name: {$column['name']}\n";
            echo "Type: {$column['type']}\n";
            echo "Not Null: {$column['notnull']}\n";
            echo "Default Value: {$column['dflt_value']}\n";
            echo "Primary Key: {$column['pk']}\n\n";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        // Describe the 'priority' table
        $stmt2 = $db->query("PRAGMA table_info(priority)");
        $columns2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Display table information for 'priority'
        foreach ($columns2 as $column2) {
            echo "Column ID: {$column2['cid']}\n";
            echo "Name: {$column2['name']}\n";
            echo "Type: {$column2['type']}\n";
            echo "Not Null: {$column2['notnull']}\n";
            echo "Default Value: {$column2['dflt_value']}\n";
            echo "Primary Key: {$column2['pk']}\n\n";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>
