<?php
    session_start();

    // Unset the session variable
    unset($_SESSION['unlock_id']);

    // Redirect back to the previous page
    header('Location: dashboard.php'); 
    exit();
?>
