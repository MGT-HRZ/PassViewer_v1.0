<?php

    function emailVerifyPopup($condition) {
        $content = " ";

        if ($condition === md5('true')) {
            $content = '
                <div id="alert-3" class="flex items-center p-4 sm:p-5 md:p-6 lg:p-5 mb-2 text-green-800 rounded-full border-2 border-green-300 bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 mx-4 sm:mx-6 md:mx-8 lg:mx-auto w-full max-w-2xl" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-6 lg:h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm sm:text-base md:text-lg lg:text-[16px] font-medium">
                        An email verify pin has been sent to your email.
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-8 lg:w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            ';
        } elseif ($condition === md5('false')) {
            $content = '
                <div id="alert-3" class="flex items-center p-4 sm:p-5 md:p-6 lg:p-5 mb-2 text-yellow-800 rounded-full border-2 border-yellow-300 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400 dark:border-yellow-800 mx-4 sm:mx-6 md:mx-8 lg:mx-auto w-full max-w-2xl" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-6 lg:h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm sm:text-base md:text-lg lg:text-[16px] font-medium">
                        Email unsuccessfully verified. Please try again.
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-8 lg:w-8 dark:bg-gray-800 dark:text-yellow-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            ';
        }

        echo $content;
        echo '<script>
            // Add event listener to the close button
            document.querySelector(\'[aria-label="Close"]\').addEventListener(\'click\', function () {
                var alert = document.getElementById("alert-3");
                alert.classList.add(\'hidden\'); // Hide the alert when the close button is clicked
            });

            document.addEventListener("DOMContentLoaded", function() {
                // Show the popup (remove "hidden" class)
                var popup = document.getElementById("alert-3");
                popup.classList.remove("hidden");

                // Set a timer for 1 minute (60,000 milliseconds)
                setTimeout(function() {
                    // Dismiss the popup by adding the "hidden" class after 1 minute
                    popup.classList.add("hidden");

                }, 10000); // 10 seconds
            });
        </script>';
    }

    function signupClearPopup($condition) {
        $content = " ";

        if ($condition === md5('true')) {
            $content = '
                <div id="alert-3" class="flex items-center p-4 sm:p-5 md:p-6 lg:p-5 mb-2 text-blue-800 rounded-full border-2 border-blue-300 bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800 mx-4 sm:mx-6 md:mx-8 lg:mx-auto w-full max-w-2xl" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-6 lg:h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm sm:text-base md:text-lg lg:text-[16px] font-medium">
                        Please complete the form below to sign in.
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-8 lg:w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            ';
        }

        echo $content;
        echo '<script>
            // Add event listener to the close button
            document.querySelector(\'[aria-label="Close"]\').addEventListener(\'click\', function () {
                var alert = document.getElementById("alert-3");
                alert.classList.add(\'hidden\'); // Hide the alert when the close button is clicked
            });

            document.addEventListener("DOMContentLoaded", function() {
                // Show the popup (remove "hidden" class)
                var popup = document.getElementById("alert-3");
                popup.classList.remove("hidden");

                // Set a timer for 1 minute (60,000 milliseconds)
                setTimeout(function() {
                    // Dismiss the popup by adding the "hidden" class after 1 minute
                    popup.classList.add("hidden");

                }, 10000); // 10 seconds
            });
        </script>';
    }

    function signupStatusPopup($condition) {
        $content = " ";

        if ($condition === md5('pass')) {
            $content = '
                <div id="alert-3" class="flex items-center p-4 sm:p-5 md:p-6 lg:p-5 mb-2 text-green-800 rounded-full border-2 border-green-300 bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 mx-4 sm:mx-6 md:mx-8 lg:mx-auto w-full max-w-2xl" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-6 lg:h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm sm:text-base md:text-lg lg:text-[16px] font-medium">
                        Sign up has been completed. Thank you!
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-8 lg:w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            ';
        } elseif ($condition === md5('fail')) {
            $content = '
                <div id="alert-3" class="flex items-center p-4 sm:p-5 md:p-6 lg:p-5 mb-2 text-red-800 rounded-full border-2 border-red-300 bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800 mx-4 sm:mx-6 md:mx-8 lg:mx-auto w-full max-w-2xl" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-6 lg:h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm sm:text-base md:text-lg lg:text-[16px] font-medium">
                        Sign up attempt fail! Something when wrong. Please try again.
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-8 lg:w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            ';
        }

        echo $content;
        echo '<script>
            // Add event listener to the close button
            document.querySelector(\'[aria-label="Close"]\').addEventListener(\'click\', function () {
                var alert = document.getElementById("alert-3");
                alert.classList.add(\'hidden\'); // Hide the alert when the close button is clicked
            });

            document.addEventListener("DOMContentLoaded", function() {
                // Show the popup (remove "hidden" class)
                var popup = document.getElementById("alert-3");
                popup.classList.remove("hidden");

                // Set a timer for 1 minute (60,000 milliseconds)
                setTimeout(function() {
                    // Dismiss the popup by adding the "hidden" class after 1 minute
                    popup.classList.add("hidden");

                }, 10000); // 10 seconds
            });
        </script>';
    }

    function wrongPassPopup($condition) {
        $content = " ";

        if ($condition === md5('true')) {
            $content = '
                <div id="alert-3" class="flex items-center p-4 sm:p-5 md:p-6 lg:p-5 mb-2 text-red-800 rounded-full border-2 border-red-300 bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800 mx-4 sm:mx-6 md:mx-8 lg:mx-auto w-full max-w-2xl" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-6 lg:h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm sm:text-base md:text-lg lg:text-[16px] font-medium">
                        Something went wrong when we tried to sign you in.
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-8 lg:w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            ';
        }

        echo $content;
        echo '<script>
            // Add event listener to the close button
            document.querySelector(\'[aria-label="Close"]\').addEventListener(\'click\', function () {
                var alert = document.getElementById("alert-3");
                alert.classList.add(\'hidden\'); // Hide the alert when the close button is clicked
            });

            document.addEventListener("DOMContentLoaded", function() {
                // Show the popup (remove "hidden" class)
                var popup = document.getElementById("alert-3");
                popup.classList.remove("hidden");

                // Set a timer for 1 minute (60,000 milliseconds)
                setTimeout(function() {
                    // Dismiss the popup by adding the "hidden" class after 1 minute
                    popup.classList.add("hidden");

                }, 10000); // 10 seconds
            });
        </script>';
    }

$temp = '
        <div id="alert-additional-content-3" class="w-[30%] p-4 mb-4 content-center text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 hidden" role="alert">
            <div class="flex items-center">
                <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <h3 class="text-lg font-medium">This is a success alert</h3>
            </div>
            <div class="mt-2 mb-4 text-black dark:text-white text-sm">
                More info about this info success goes here. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.
            </div>
            <!-- <div class="flex">
                <button type="button" class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                    <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                </svg>
                View more
                </button>
                <button type="button" class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-400 dark:hover:text-white dark:focus:ring-red-800" data-dismiss-target="#alert-additional-content-3" aria-label="Close">
                Dismiss
                </button>
            </div> -->
        </div>
    ';
