<?php

    include_once "../../img/img-test.php";

    //  This file will pop up welcome 

    if (isset($_GET['welcome'])) {
        $input_success = $_GET['welcome'];

        if ($_SESSION['user_id'] === 1) {
            $image_path = $img_test1;
            // $image_path_online = ''.$pro_image;

            $style_pro_img = '<style>
                #pro-image {
                    // width: 150px;
                    // height: 150px;

                    /* Cannot drag image */
                    -webkit-user-drag: none;
                    -khtml-user-drag: none;
                    -moz-user-drag: none;
                    user-select: none;
                }
            </style>';

            $img = '<img class="img-profile w-full h-full object-cover" id="pro-image" src="'.$image_path.'">';

            //  If internet is available
            // $img_online = '<img class="img-profile rounded-circle mt-3 mb-3" id="pro-image" src="'.$image_path_online.'">';
        }

        else {
            $image_path = $img_test2;
            // $image_path_online = ''.$pro_image;

            $style_pro_img = '<style>
                #pro-image {
                    // width: 150px;
                    // height: 175px;

                    /* Cannot drag image */
                    -webkit-user-drag: none;
                    -khtml-user-drag: none;
                    -moz-user-drag: none;
                    user-select: none;
                }
            </style>';
            
            $img = '<img class="img-profile w-full h-full object-cover" id="pro-image" src="'.$image_path.'">';

            //  If internet is available
            // $img_online = '<img class="img-profile rounded-circle mt-3 mb-3" id="pro-image" src="'.$image_path_online.'">';
        }

        echo '
            <div>
                <!-- Modal Structure -->
                <div id="welcomeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-[5%] border-4 border-gray-400 dark:border-gray-700 shadow-lg w-[375px] md:w-[500px] sm:w-[500px] mt-[8%] md:mt-[1%] mt-[1%] p-8">
                        <div class="flex justify-end">
                            <button id="closeModal" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-center">
                            <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">Welcome!</h1>
                            <div class="mt-6">
                                <!-- Profile Image Section -->
                                <div id="imageContainer" class="w-60 h-60 md:w-80 md:h-80 sm:w-80 sm:h-80 mx-auto mb-4 rounded-full overflow-hidden border-8 border-gray-400 dark:border-gray-600">
                                    <!-- Dynamically output profile image -->
                                    ' . $img . '
                                </div>

                                <!-- Dynamically output the user\'s name -->
                                <p class="text-4xl font-semibold text-gray-700 dark:text-gray-300"><span class="text-blue-600">' . $_SESSION['user_name'] . '</span></p>
                            </div>
                            <p class="text-lg mt-4 text-gray-600 dark:text-gray-400">We\'re glad to have you here! Explore your dashboard and get started.</p>
                            <div class="mt-6">
                                <a href="dashboard.php" class="inline-block px-6 py-2 text-lg bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300 dark:bg-blue-600 dark:hover:bg-blue-700">Go to Dashboard &nbsp;<i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- jQuery to show and close the modal with fade-out effect -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    // Show the modal when the page loads
                    $(document).ready(function() {
                        $("#welcomeModal").removeClass("hidden").addClass("flex").hide().fadeIn(500); // Fade-in effect
                    });

                    // Close the modal when the close button is clicked with fade-out effect
                    $("#closeModal").click(function() {
                        $("#welcomeModal").fadeOut(500, function() {
                            $(this).removeClass("flex").addClass("hidden");
                        });
                    });
                </script>
            </div>
        ';

        if ($_SESSION['user_id'] >= 2) {
            echo '                    
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const timelimit = 8;
                        const loop_img_time = timelimit * 1000;

                        fetch("../../img/data.json") // Ensure the correct path to your JSON file
                            .then(res => res.json())
                            .then(data => {
                                if (!data || data.length === 0) {
                                    console.error("No data found in the JSON file.");
                                    return;
                                }

                                // Sort the data by \'id\' to ensure we start with id=1
                                data.sort((a, b) => a.id - b.id);

                                const profileImageEl_welc = document.getElementById("pro-image");
                                if (!profileImageEl_welc) {
                                    console.error("Could not find the image element (#pro-image).");
                                    return;
                                }

                                // Function to display images like a GIF with transitions for each post
                                function displayImages(post) {
                                    return new Promise(resolve => {
                                        let imageIndex = 1;

                                        // Function to update the image source and create the fade effect
                                        function updateImage() {
                                            if (post[`img${imageIndex}`]) {
                                                profileImageEl_welc.src = post[`img${imageIndex}`];
                                                profileImageEl_welc.alt = `${post.name} - Image ${imageIndex}`;

                                                // Fade in the new image
                                                profileImageEl_welc.style.transition = "opacity 1s";
                                                profileImageEl_welc.style.opacity = 1;

                                                // After 2 seconds (image displayed), fade out the current image
                                                setTimeout(() => {
                                                    profileImageEl_welc.style.opacity = 0;
                                                }, (loop_img_time - 1000)); // Adjust timing as needed

                                                // Move to the next image after 3 seconds (1 second for fade-out)
                                                imageIndex++;
                                                if (!post[`img${imageIndex}`]) {
                                                    // Once all images of a post are displayed, resolve the promise to move to the next post
                                                    clearInterval(imageInterval);
                                                    resolve(); // Resolve the promise to go to the next post
                                                }
                                            }
                                        }

                                        // Update the image every 3 seconds (change image every 3 seconds)
                                        const imageInterval = setInterval(updateImage, loop_img_time);
                                    });
                                }

                                // Function to cycle through posts with looping
                                async function cyclePosts() {
                                    while (true) { // Infinite loop
                                        for (let post of data) {
                                            await displayImages(post); // Wait until all images of the current post are displayed
                                        }
                                    }
                                }

                                // Start cycling through the posts
                                cyclePosts();
                            })
                            .catch(err => {
                                console.error("Error fetching data:", err);
                            });
                    });
                </script>';
        }

    }
