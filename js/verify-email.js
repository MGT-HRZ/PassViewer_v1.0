const emailInput = document.getElementById('email');

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

// Deafult state of submit button (Unable to submit)
submitUnable(submitButtonEnable);

emailInput.addEventListener('input', function() {
    // Check if the email input is valid and not empty

    // Simple email pattern
    const emailPattern = /^(?![_.-])[A-Za-z0-9._%+-]+(?<=\S)@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    if (emailPattern.test(emailInput.value.trim())) {
        submitEnable(submitButtonEnable);

        submitButtonEnable.addEventListener('click', function() {
            setTimeout(() => {
                submitUnable(submitButtonEnable);
            }, 150);
        });
    } else {
        submitUnable(submitButtonEnable);
    }
});