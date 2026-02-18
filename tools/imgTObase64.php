<?php
    // Path to the image file
    $imagePath = 'path/to/your/image.jpg';

    // Get the file extension from the image path
    $fileExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

    // Read the image file content
    $imageData = file_get_contents($imagePath);

    // Encode the image data in Base64
    $base64Image = base64_encode($imageData);

    // Check the file extension and prepend the appropriate data URI scheme
    if ($fileExtension == "jpg" || $fileExtension == "jpeg") {
        $base64Image = "data:image/jpeg;base64," . $base64Image;
    } else if ($fileExtension == "png") {
        $base64Image = "data:image/png;base64," . $base64Image;
    } else if ($fileExtension == "gif") {
        $base64Image = "data:image/gif;base64," . $base64Image;
    } else {
        // Handle unsupported file types
        $base64Image = "Unsupported image format.";
    }

    // Output the Base64 encoded string
    echo $base64Image;
?>

