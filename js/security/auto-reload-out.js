function AutoReloadOut(timelimit) {
    // URL to redirect to after inactivity
    const redirectUrl = '../../pages/signout/signout.php?out';

    // Set the delay time to 5 seconds (5 * 1000 milliseconds)
    const delayTime = 5 * 1000; // 5 seconds

    // Popup appears 15 seconds before refresh (adjusted for 30 seconds session time)
    const popupTime = 15 * 1000; // 15 seconds before the session ends

    // Set the inactivity time limit (converted to milliseconds)
    const inactivityTimeLimit = timelimit * 1000; // in milliseconds

    let delayTimer;
    let inactivityTimer;

    // Function to show popup and prompt the user
    function showPopup() {
        // Show a confirmation popup 10 seconds before the session expires
        const confirmation = confirm("Your session will expire in 15 seconds. Do you want to continue?");
        
        if (confirmation) {
            // User clicked "OK" on the confirmation dialog, reset the timers
            resetTimers();
            window.location.reload();
        } else {
            // User clicked "Cancel", redirect to the logout URL
            window.location.href = redirectUrl;
        }
    }

    // Function to refresh the page or redirect to the logout page
    function refreshPage() {
        window.location.href = redirectUrl;
    }

    // Function to start the inactivity timer
    function startInactivityTimer() {
        inactivityTimer = setTimeout(() => {
            showPopup(); // Show popup when inactivity reaches the time limit
            setTimeout(refreshPage, popupTime); // Redirect after popupTime
        }, inactivityTimeLimit - popupTime); // Adjusted to trigger popup before timeout
    }

    // Function to reset timers
    function resetTimers() {
        clearTimeout(delayTimer);
        clearTimeout(inactivityTimer);
        delayTimer = setTimeout(startInactivityTimer, delayTime); // Restart inactivity timer
    }

    // Event listeners to reset timers on user interaction
    document.addEventListener('mousemove', resetTimers);
    document.addEventListener('keydown', resetTimers);

    // Initial setup to start the inactivity timer
    resetTimers();
}

AutoReloadOut(60); // Set inactivity time to 1 minute