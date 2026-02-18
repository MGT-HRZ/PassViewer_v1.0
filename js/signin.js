/* This function is use to see whether password are the same or not before sign in. */

const passwordInput = document.getElementById('password');
const passwordEmptyError = document.getElementById('password-empty-error');
const passwordLengthError = document.getElementById('password-length-error');
const passwordUppercaseError = document.getElementById('password-uppercase-error');
const passwordLowercaseError = document.getElementById('password-lowercase-error');
const passwordSpecialError = document.getElementById('password-special-error');
const passwordNumberError = document.getElementById('password-number-error');

const digit_inputs = [
    document.getElementById('verification-code1'),
    document.getElementById('verification-code2'),
    document.getElementById('verification-code3'),
    document.getElementById('verification-code4'),
    document.getElementById('verification-code5'),
    document.getElementById('verification-code6')
];

// Disable all digit inputs by default
digit_inputs.forEach(input => input.disabled = true);

const submitButtonEnable = document.getElementById('submit-btn');

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

localStorage.setItem('status', 'locked');

// Deafult state of submit button (Unable to submit)
submitUnable(submitButtonEnable);

const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[*.@_.$&#])[A-Za-z\d*.@_.$&#]{8,}$/;

function validatePasswordFormat() {
    const passwordValue = passwordInput.value;

    // Check password length
    const isLengthValid = passwordValue.length >= 8;
    if (!isLengthValid) {
        passwordLengthError.classList.remove('hidden');
    } else {
        passwordLengthError.classList.add('hidden');
    }

    // Check for uppercase letter
    const hasUppercase = /[A-Z]/.test(passwordValue);
    if (!hasUppercase) {
        passwordUppercaseError.classList.remove('hidden');
    } else {
        passwordUppercaseError.classList.add('hidden');
    }

    // Check for lowercase letter
    const hasLowercase = /[a-z]/.test(passwordValue);
    if (!hasLowercase) {
        passwordLowercaseError.classList.remove('hidden');
    } else {
        passwordLowercaseError.classList.add('hidden');
    }

    // Check for special character
    const hasSpecialChar = /[*.@_.$&#]/.test(passwordValue);
    if (!hasSpecialChar) {
        passwordSpecialError.classList.remove('hidden');
    } else {
        passwordSpecialError.classList.add('hidden');
    }

    // Check for at least one number
    const hasNumber = /\d/.test(passwordValue);
    if (!hasNumber) {
        passwordNumberError.classList.remove('hidden');
    } else {
        passwordNumberError.classList.add('hidden');
    }

    return isLengthValid && hasUppercase && hasLowercase && hasSpecialChar && hasNumber;
}

function checkPasswordsMatch() {
    const isPasswordValid = validatePasswordFormat();

    // Handle empty fields
    function handleEmptyField(inputElement, errorElement) {
        if (inputElement.value === '') {
            inputElement.classList.add('border-red-500', 'dark:border-red-500');
            errorElement.classList.remove('hidden');
        } else {
            inputElement.classList.remove('border-red-500', 'dark:border-red-500');
            errorElement.classList.add('hidden');
        }
    }

    handleEmptyField(passwordInput, passwordEmptyError);

    // If passwords match and both are valid

    // * Need to add logic to check if password is valid from the database *
    if (passwordInput.value && isPasswordValid) {
        passwordInput.classList.add('border-green-500', 'dark:border-green-500');
        digit_inputs.forEach(input => input.disabled = false);
    } else {
        passwordInput.classList.remove('border-green-500', 'dark:border-green-500');
        digit_inputs.forEach(input => input.disabled = true);
    }

    // If both fields are empty
    if (passwordInput.value === '' && confirmPasswordInput.value === '') {
        passwordInput.classList.add('border-red-500', 'dark:border-red-500');
        passwordEmptyError.classList.remove('hidden');
    }
}

// Add event listeners
passwordInput.addEventListener('input', checkPasswordsMatch);

/* End function. */



/* This function is to hide and unhide user password during sign up process. */

const togglePasswordVisibility = document.getElementById('toggle-password-visibility');

// Function to toggle visibility
function toggleVisibility(input, button) {
    const isPasswordVisible = input.type === 'password';
    input.type = isPasswordVisible ? 'text' : 'password';
    const icon = button.querySelector('i');
    icon.classList.toggle('fa-eye-slash', !isPasswordVisible);
    icon.classList.toggle('fa-eye', isPasswordVisible);
}

// Add event listeners
togglePasswordVisibility.addEventListener('click', () => {
    toggleVisibility(passwordInput, togglePasswordVisibility);
});

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

// Trigger validation when any of the verification code fields change
function validateVerificationCode() {
    const code = [
        document.getElementById('verification-code1').value,
        document.getElementById('verification-code2').value,
        document.getElementById('verification-code3').value,
        document.getElementById('verification-code4').value,
        document.getElementById('verification-code5').value,
        document.getElementById('verification-code6').value
    ].join('');  // Concatenate all input values into one string

    const isValidCode = /^[0-9]{6}$/.test(code); // Check if it's exactly 6 digits
    const errorElement = document.getElementById('verification-code-error');

    if (!isValidCode) {
        errorElement.classList.remove('hidden');  // Show error message if code is invalid
        // Optionally, remove valid class if any input was previously valid
        digit_inputs.forEach(input => input.classList.remove('border-green-500', 'dark:border-green-500'));
    } else {
        errorElement.classList.add('hidden');  // Hide error message if code is valid
        // Add valid class to each input
        digit_inputs.forEach(input => input.classList.add('border-green-500', 'dark:border-green-500'));
    }

    return isValidCode;
}

// Enable/Disable submit button based on password and verification code validity
function checkSubmitButton() {
    // Check if the password and confirm password are valid and match
    const isPasswordValid = validatePasswordFormat();  // Validate password format

    // Check if the verification code is valid
    const isVerificationCodeValid = validateVerificationCode();  // Validate 6-digit code

    // Enable/Disable submit button based on the above conditions
    if (isPasswordValid && isVerificationCodeValid) {
        submitEnable(submitButtonEnable);  // Enable submit button if all conditions are met
    } else {
        submitUnable(submitButtonEnable);  // Disable submit button if any condition is not met
    }
}

// Add event listeners to trigger validation whenever a relevant field is updated
passwordInput.addEventListener('input', checkSubmitButton);
document.getElementById("verification-code1").addEventListener('input', checkSubmitButton);
document.getElementById("verification-code2").addEventListener('input', checkSubmitButton);
document.getElementById("verification-code3").addEventListener('input', checkSubmitButton);
document.getElementById("verification-code4").addEventListener('input', checkSubmitButton);
document.getElementById("verification-code5").addEventListener('input', checkSubmitButton);
document.getElementById("verification-code6").addEventListener('input', checkSubmitButton);

// Attach event listeners for each verification code input field
document.getElementById("verification-code1").addEventListener('input', function(event) {
    restrictToNumbers(event);  // Ensure only numbers are input
    moveFocus(this, 'verification-code2', '');  // Only move focus if the input is valid
    validateVerificationCode(); // Validate after input
});
document.getElementById("verification-code2").addEventListener('input', function(event) {
    restrictToNumbers(event);  // Ensure only numbers are input
    moveFocus(this, 'verification-code3', 'verification-code1');  // Only move focus if the input is valid
    validateVerificationCode(); // Validate after input
});
document.getElementById("verification-code3").addEventListener('input', function(event) {
    restrictToNumbers(event);  // Ensure only numbers are input
    moveFocus(this, 'verification-code4', 'verification-code2');  // Only move focus if the input is valid
    validateVerificationCode(); // Validate after input
});
document.getElementById("verification-code4").addEventListener('input', function(event) {
    restrictToNumbers(event);  // Ensure only numbers are input
    moveFocus(this, 'verification-code5', 'verification-code3');  // Only move focus if the input is valid
    validateVerificationCode(); // Validate after input
});
document.getElementById("verification-code5").addEventListener('input', function(event) {
    restrictToNumbers(event);  // Ensure only numbers are input
    moveFocus(this, 'verification-code6', 'verification-code4');  // Only move focus if the input is valid
    validateVerificationCode(); // Validate after input
});
document.getElementById("verification-code6").addEventListener('input', function(event) {
    restrictToNumbers(event);  // Ensure only numbers are input
    moveFocus(this, '', 'verification-code5');  // Only move focus if the input is valid
    validateVerificationCode(); // Validate after input
});

/* End function. */



/* This function will reset form's input fields and visibility state. */

const resetButtonField = document.getElementById('reset-btn');

resetButtonField.addEventListener('click', () => {
    // Reset the password and confirm password inputs
    passwordInput.value = '';

    // Reset the password visibility state to "hidden"
    passwordInput.type = 'password';

    // Reset visibility icons to "eye" (password hidden)
    togglePasswordVisibility.querySelector('i').classList.add('fa-eye-slash');
    togglePasswordVisibility.querySelector('i').classList.remove('fa-eye');

    // Remove validation error states
    passwordInput.classList.remove('border-red-500', 'dark:border-red-500', 'border-green-500', 'dark:border-green-500');

    passwordEmptyError.classList.add('hidden');
    passwordLengthError.classList.add('hidden');
    passwordUppercaseError.classList.add('hidden');
    passwordLowercaseError.classList.add('hidden');
    passwordSpecialError.classList.add('hidden');

    digit_inputs.forEach(input => {
        input.value = '';  // Clear the value
        input.classList.remove('border-red-500', 'dark:border-red-500', 'border-green-500', 'dark:border-green-500');  // Remove any applied borders
        input.disabled = true;  // Disable the input
    });

    // Hide any verification code errors
    const errorElement = document.getElementById('verification-code-error');
    if (errorElement) {
        errorElement.classList.add('hidden');
    }

    // Unable submit button
    submitUnable(submitButtonEnable);
});

/* End function. */
