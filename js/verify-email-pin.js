const digit_inputs = [
    document.getElementById('temp-auth-code1'),
    document.getElementById('temp-auth-code2'),
    document.getElementById('temp-auth-code3'),
    document.getElementById('temp-auth-code4'),
    document.getElementById('temp-auth-code5'),
    document.getElementById('temp-auth-code6')
];

const submitButtonPIN = document.getElementById('submit-btn-pin');

function submitUnable(id_btn) {
    id_btn.disabled = true;
    id_btn.classList.remove('cursor-pointer');
    id_btn.classList.add('cursor-not-allowed', 'opacity-50');
}

function submitEnable(id_btn) {
    id_btn.disabled = false;
    id_btn.classList.remove('cursor-not-allowed', 'opacity-50');
    id_btn.classList.add('cursor-pointer');
}

// Deafult state of submit button (Unable to submit)
submitUnable(submitButtonPIN);

/*   */

function AutoReloadOut(timelimit) {
    const getVerifyEmail = localStorage.getItem("verify_email");
    // URL to logout to after inactivity
    const redirectUrl = 'verify-email.php?email_verify=' + getVerifyEmail;

    // Set the delay time to 5 seconds (5 * 1000 milliseconds)
    const delayTime = 5 * 1000; // 5 seconds

    // Popup appears 20 seconds before refresh
    const popupTime = 1 * 1000; 

    // Set the inactivity time limit
    const inactivityTimeLimit = timelimit * 1000; // in seconds

    let delayTimer;
    let inactivityTimer;

    function startInactivityTimer() {
        inactivityTimer = setTimeout(() => {
            showPopup();
            setTimeout(refreshPage, popupTime);
        }, inactivityTimeLimit - popupTime);
    }

    function resetTimers() {
        clearTimeout(delayTimer);
        clearTimeout(inactivityTimer);
        delayTimer = setTimeout(startInactivityTimer, delayTime);
    }

    function refreshPage() {
        // You can customize this part to reload the page or perform other actions
        // location.reload();
        window.location.href = redirectUrl;
    }

    function showPopup() {
        setTimeout(refreshPage, popupTime);
        // // Replace this alert with your own popup implementation
        // const confirmation = confirm("Your session will expire in 20 seconds. Do you want to continue?");
        
        // if (confirmation) {
        //     // User clicked "OK" on the confirmation dialog, refresh page
        //     location.reload();
        // } 
        
        // else {
        //     // User clicked "Cancel" or closed the dialog, proceed with refresh after popupTime
        //     setTimeout(refreshPage, popupTime);
        // }
    }

    // Event listeners to reset the timers on user interaction
    document.addEventListener('mousemove', resetTimers);
    document.addEventListener('keydown', resetTimers);

    // Initial setup
    resetTimers();
}

window.onload = function() {
    AutoReloadOut(30); // 1 minutes
};

/* End function. */



/* This function is to automatically move focus to the next input or previous input for backspace and handle the 6-digit code. */

function moveFocus(currentInput, nextInputId, previousInputId) {
    // If the current input contains only digits and the length is equal to the max length, move focus to the next field
    if (currentInput.value.length == currentInput.maxLength && /^[0-9]$/.test(currentInput.value)) {
        const nextInput = document.getElementById(nextInputId);
        if (nextInput) {
            nextInput.focus();
        }
    }

    // Handle backspace to move focus to the previous input if the field is empty
    currentInput.addEventListener('keydown', function(event) {
        if (event.key === 'Backspace' && currentInput.value === '') {
            const previousInput = document.getElementById(previousInputId);
            if (previousInput) {
                previousInput.focus();
            }
        }
    });
}

// Restrict input to numeric values only
function restrictToNumbers(event) {
    const value = event.target.value;
    // Remove any non-digit characters
    event.target.value = value.replace(/\D/g, '');
}

// Trigger validation when any of the temp-auth code fields change
function validateTempAuthCode() {
    const code = [
        document.getElementById('temp-auth-code1').value,
        document.getElementById('temp-auth-code2').value,
        document.getElementById('temp-auth-code3').value,
        document.getElementById('temp-auth-code4').value,
        document.getElementById('temp-auth-code5').value,
        document.getElementById('temp-auth-code6').value
    ].join(''); // Concatenate all input values into one string

    const isValidCode = /^[0-9]{6}$/.test(code); // Check if it's exactly 6 digits
    const errorElement = document.getElementById('temp-auth-code-error');

    if (!isValidCode) {
        errorElement.classList.remove('hidden'); // Show error message if code is invalid
        // Optionally, remove valid class if any input was previously valid
        digit_inputs.forEach(input => input.classList.remove('border-green-500', 'dark:border-green-500'));
    } else {
        errorElement.classList.add('hidden'); // Hide error message if code is valid
        // Add valid class to each input
        digit_inputs.forEach(input => input.classList.add('border-green-500', 'dark:border-green-500'));
    }

    return isValidCode;
}

function checkSubmitButton() {
    // Check if the temp-auth code is valid
    const isTempAuthCodeValid = validateTempAuthCode(); // Validate 6-digit code

    // Enable/Disable submit button based on the above conditions
    if (isTempAuthCodeValid) {
        submitEnable(submitButtonPIN); // Enable submit button if all conditions are met
    } else {
        submitUnable(submitButtonPIN); // Disable submit button if any condition is not met
    }
}

// Add event listeners to trigger validation whenever a relevant field is updated
document.getElementById("temp-auth-code1").addEventListener('input', checkSubmitButton);
document.getElementById("temp-auth-code2").addEventListener('input', checkSubmitButton);
document.getElementById("temp-auth-code3").addEventListener('input', checkSubmitButton);
document.getElementById("temp-auth-code4").addEventListener('input', checkSubmitButton);
document.getElementById("temp-auth-code5").addEventListener('input', checkSubmitButton);
document.getElementById("temp-auth-code6").addEventListener('input', checkSubmitButton);

// Attach event listeners for each temp-auth code input field
document.getElementById("temp-auth-code1").addEventListener('input', function(event) {
    restrictToNumbers(event); // Ensure only numbers are input
    moveFocus(this, 'temp-auth-code2', ''); // Only move focus if the input is valid
    validateTempAuthCode(); // Validate after input
});
document.getElementById("temp-auth-code2").addEventListener('input', function(event) {
    restrictToNumbers(event); // Ensure only numbers are input
    moveFocus(this, 'temp-auth-code3', 'temp-auth-code1'); // Only move focus if the input is valid
    validateTempAuthCode(); // Validate after input
});
document.getElementById("temp-auth-code3").addEventListener('input', function(event) {
    restrictToNumbers(event); // Ensure only numbers are input
    moveFocus(this, 'temp-auth-code4', 'temp-auth-code2'); // Only move focus if the input is valid
    validateTempAuthCode(); // Validate after input
});
document.getElementById("temp-auth-code4").addEventListener('input', function(event) {
    restrictToNumbers(event); // Ensure only numbers are input
    moveFocus(this, 'temp-auth-code5', 'temp-auth-code3'); // Only move focus if the input is valid
    validateTempAuthCode(); // Validate after input
});
document.getElementById("temp-auth-code5").addEventListener('input', function(event) {
    restrictToNumbers(event); // Ensure only numbers are input
    moveFocus(this, 'temp-auth-code6', 'temp-auth-code4'); // Only move focus if the input is valid
    validateTempAuthCode(); // Validate after input
});
document.getElementById("temp-auth-code6").addEventListener('input', function(event) {
    restrictToNumbers(event); // Ensure only numbers are input
    moveFocus(this, '', 'temp-auth-code5'); // Only move focus if the input is valid
    validateTempAuthCode(); // Validate after input
});

/* End function. */



/* This function will reset form's input fields and visibility state. */

const resetButtonField = document.getElementById('reset-btn');

resetButtonField.addEventListener('click', () => {

    digit_inputs.forEach(input => {
        input.value = '';  // Clear the value
        input.classList.remove('border-red-500', 'dark:border-red-500', 'border-green-500', 'dark:border-green-500');  // Remove any applied borders
    });

    // Hide any verification code errors
    const errorElement = document.getElementById('temp-auth-code-error');
    if (errorElement) {
        errorElement.classList.add('hidden');
    }

    // Unable submit button
    submitUnable(submitButtonPIN);
});

/* End function. */
