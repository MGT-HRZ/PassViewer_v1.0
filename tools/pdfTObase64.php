<?php
    // Path to the PDF file
    $pdfFilePath = 'path/to/your/file.pdf';

    // Read the content of the PDF into a string
    $pdfContent = file_get_contents($pdfFilePath);

    // Encode the PDF content into Base64
    $pdfBase64 = base64_encode($pdfContent);

    // Display the Base64 encoded string
    echo "data:application/pdf;base64," . $pdfBase64;
?>
