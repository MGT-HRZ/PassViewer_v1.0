<?php

    session_start();

    $num_dir = 2;

    include_once "../../config/config.php";

    include_once "../../pages/signout/signout.php";
    include_once "../../pages/signout/verify-signout.php";

    $unlock_id = " ";

    if (isset($_SESSION['unlock_id'])) {
        $unlock_id = $_SESSION['unlock_id'];
        // echo '<script>alert("'.$unlock_id.'");</script>';
    } else {
        $unlock_id = "EMPTY";
    }

    if (isset($_SESSION) === true) {
        if (isSignIn() === $_SESSION['user_email']) {

            try {
                $user_email = $_SESSION['user_email'];

                // Connect to the SQLite database
                $db = new PDO('sqlite:../../database/main/PassViewer.db');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare the SQL query
                $stmt = $db->prepare("SELECT id, name, email, verification_code FROM users WHERE email = :email AND id = :target_id");
                $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
                $stmt->bindParam(':target_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $stmt->execute();

                // Fetch the user data
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $user_name = $user['name'];
                    $user_email = $user['email'];
                    $user_very_code = $user['verification_code'];
                } else {
                    session_destroy();
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <?php
        include_once "../../components/requirements_pages.php";
        include_once "../../css/css-cdn.php";
    ?>
    <title>Dashboard | <?php echo $APP_NAME; ?></title>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col">
    <?php
        // Popups
        include_once "../../components/popups/popups.php";
        include_once "../../components/popups/welcome-log.php";
    ?>

    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <?php
            include_once "../../components/topbar/topbar.php";
            include_once "../../components/sidebar.php";
        ?>

        <main class="p-4 md:ml-64 h-auto pt-20 text-black dark:text-white">
            <!-- First grid layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                <div class="border-2 rounded-lg border-gray-300 dark:border-gray-600 col-span-1 sm:col-span-2 h-auto md:h-[1000px]">

                    <?php
                    
                        // Connect to SQLite database and fetch the Base64 PDF from the 'priority' table
                        try {
                            $db_temp = new PDO('sqlite:../../database/main/PassViewer.db');
                            $db_temp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Query to get the PDF from the 'priority' table (you can customize this query if needed)
                            $sqlPriority = "SELECT pdf FROM priority WHERE id = :id";
                            $stmtPriority = $db_temp->prepare($sqlPriority);
                            $stmtPriority->bindValue(':id', 1, PDO::PARAM_INT);  // Replace 1 with the desired ID
                            $stmtPriority->execute();

                            // Fetch the PDF Base64 data
                            $pdfBase64 = $stmtPriority->fetchColumn();

                            if (!$pdfBase64) {
                                echo '<div class="flex justify-center items-center h-screen">
                                    <div class="bg-gray-100 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-sm md:text-lg sm:text-lg text-gray-600 dark:text-gray-300 rounded-full p-8 md:p-12 sm:p-12">
                                        No PDF found in the database.
                                    </div>
                                </div>
                                ';
                            }

                            // Pass the Base64 PDF to the JavaScript code (we'll use it inside the JS)
                            $pdfBase64Encoded = htmlspecialchars($pdfBase64, ENT_QUOTES, 'UTF-8');  // Safely encode the Base64 string for use in JavaScript

                        } catch (PDOException $e) {
                            echo "Error fetching PDF: " . $e->getMessage();
                            exit;
                        } catch (Exception $e) {
                            echo $e->getMessage();
                            exit;
                        }
                    
                    ?>

                    <div id="pdf-container" class="blur-xl"></div>
                </div>
                <div id="file-upload-form">
                    <div
                        class="border-2 rounded-lg border-gray-300 dark:border-gray-600 h-80 md:h-[1000px] flex items-center justify-center bg-gray-100 dark:bg-gray-800 relative"
                        id="file-drop-area"
                        ondrop="handleDrop(event)"
                        ondragover="handleDragOver(event)"
                    >
                        <input type="file" id="file-input" class="hidden w-full h-80 md:h-[1000px]" multiple accept="application/pdf" onchange="handleFileSelect(event)" />
                        <label for="file-input" class="cursor-pointer font-semibold text-center text-gray-600 dark:text-gray-300">
                            <p>Drag and drop PDF files here</p>
                            <p>or click to select PDF files</p>
                            <br>
                            <ul id="file-list" class="text-blue-600"></ul>
                        </label>
                        <form id="upload-form" action="upload-priority-db.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="files" id="file-input-hidden">
                            <button type="submit" id="file-submit" class="absolute top-2 left-1/2 transform -translate-x-1/2 w-80 h-auto md:h-40 sm:h-40 text-base md:text-3xl sm:text-3xl font-semibold bg-primary-500 text-white p-2 rounded-full hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-500 ">
                                Submit
                            </button>
                            <button type="reset" id="file-reset" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 w-80 h-auto md:h-40 sm:h-40 text-base md:text-3xl sm:text-3xl font-semibold bg-red-500 text-white p-2 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-500">
                                Reset
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php
        include_once "../../components/footer.php";
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            let status = localStorage.getItem('status');  // Store the state in localStorage to persist it across page reloads

            if (status === 'locked') {
                let inptSKey = window.prompt("Security Key");

                // Apply MD5 hashing to the input
                let hashedKey = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5(inptSKey).toString()).toString()).toString(); // Convert to base64 for consistency

                // Compare the hashed key (replace with PHP output for dynamic check)
                if (hashedKey === "<?php echo $user_very_code; ?>") {
                    localStorage.setItem('status', 'unlocked');  // Save the unlocked state in localStorage
                    alert("Unlocked");
                } else {
                    window.location.reload();
                }
            }
        });
    </script>

    <?php
        include_once "pdf-viewer-js.php";
    ?>

    <script src="../../js/security/auto-reload-out.js"></script>

    <!-- <script src="../../js/show-pdf.js"></script> -->

    <script src="../../js/drag_n_drop_file.js"></script>

    <script src="../../js/script.js"></script>

    <?php
        include_once "../../js/js-cdn.php";
    ?>

    <script type="text/javascript">
        // Disable the back button behavior
        function noBack() {
            window.history.forward();
        }
        setTimeout("noBack()", 0);

        window.onunload = function () {
            null;
        }
    </script>

    <?php
        if (isset($_GET['unlock']) && $_GET['unlock'] === $unlock_id) {
            echo "<script>
                const blur = document.getElementById('pdf-container');
                blur.classList.remove('blur-xl');
            </script>";
        } else {
            echo "<script>
                const blur = document.getElementById('pdf-container');
                blur.classList.add('blur-xl');
            </script>";
        }

        if (!isSignIn()) {
            echo "<script>
                const blur = document.getElementById('pdf-container');
                blur.classList.add('blur-xl');
            </script>";

            header("Location: ../signin/signin.php");
        }
    ?>

<?php

        } else {
            header("Location: ../signin/signin.php");
        }
    } else {
        header("Location: ../signin/signin.php");
    }

?>

</body>
</html>

