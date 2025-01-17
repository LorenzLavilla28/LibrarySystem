document.addEventListener('DOMContentLoaded', function() {
    // Validation states
    let isFirstNameValid = false;
    let isLastNameValid = false;
    let isEmailValid = false;
    let isPasswordValid = false;
    let isPasswordMatch = false;
    const registerForm = document.getElementById('registerForm');
    

    // Password criteria
    const passwordCriteria = {
        minLength: { met: false, message: 'At least 8 characters' },
        hasUpperCase: { met: false, message: 'At least one uppercase letter' },
        hasLowerCase: { met: false, message: 'At least one lowercase letter' },
        hasNumber: { met: false, message: 'At least one number' },
        hasSpecial: { met: false, message: 'At least one special character' }
    };

    // Initialize modal and buttons
    const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
    const registerBtn = document.querySelector('.btn-outline-light.btn-custom');
    const registerSubmitBtn = document.querySelector('#registerForm button[type="submit"]');

    // Set up modal trigger
    if (registerBtn) {
        registerBtn.addEventListener('click', () => {
            registerModal.show();
        });
    }

    // First Name validation
    document.getElementById('firstName').addEventListener('input', function() {
        const firstName = this.value;
        const errorElement = document.getElementById('firstNameError');
        
        isFirstNameValid = firstName.length > 1;
        
        if (firstName === '') {
            errorElement.className = 'form-text';
            errorElement.textContent = '';
        } else if (isFirstNameValid) {
            errorElement.className = 'form-text text-success';
            errorElement.textContent = 'Valid first name!';
        } else {
            errorElement.className = 'form-text text-danger';
            errorElement.textContent = 'First name must be longer than 1 character';
        }
        toggleSubmitButton();
    });

    // Last Name validation
    document.getElementById('lastName').addEventListener('input', function() {
        const lastName = this.value;
        const errorElement = document.getElementById('lastNameError');
        
        isLastNameValid = lastName.length > 1;
        
        if (lastName === '') {
            errorElement.className = 'form-text';
            errorElement.textContent = '';
        } else if (isLastNameValid) {
            errorElement.className = 'form-text text-success';
            errorElement.textContent = 'Valid last name!';
        } else {
            errorElement.className = 'form-text text-danger';
            errorElement.textContent = 'Last name must be longer than 1 character';
        }
        toggleSubmitButton();
    });

    // Email validation
    document.getElementById('email').addEventListener('input', function() {
        const email = this.value;
        const errorElement = document.getElementById('emailError');
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        isEmailValid = emailPattern.test(email);
        
        if (email === '') {
            errorElement.className = 'form-text';
            errorElement.textContent = '';
        } else if (isEmailValid) {
            errorElement.className = 'form-text text-success';
            errorElement.textContent = 'Valid email format!';
        } else {
            errorElement.className = 'form-text text-danger';
            errorElement.textContent = 'Please enter a valid email address';
        }
        toggleSubmitButton();
    });

    // Password validation with minimal debounce
    let passwordTimeout;
    document.getElementById('password').addEventListener('input', function() {
        clearTimeout(passwordTimeout);
        const password = this.value;
        
        passwordTimeout = setTimeout(() => {
            // Check each criteria
            passwordCriteria.minLength.met = password.length >= 8;
            passwordCriteria.hasUpperCase.met = /[A-Z]/.test(password);
            passwordCriteria.hasLowerCase.met = /[a-z]/.test(password);
            passwordCriteria.hasNumber.met = /[0-9]/.test(password);
            passwordCriteria.hasSpecial.met = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            // Create feedback list
            let feedbackHtml = '<div class="mt-2" id="passwordCriteriaList"><small>';
            for (const [key, value] of Object.entries(passwordCriteria)) {
                const color = value.met ? 'text-success' : 'text-danger';
                feedbackHtml += `<div class="${color}">
                    ${value.met ? '✓' : '✗'} ${value.message}
                </div>`;
            }
            feedbackHtml += '</small></div>';
            
            // Update password validation state
            isPasswordValid = Object.values(passwordCriteria).every(criteria => criteria.met);
            
            // Update UI
            const existingList = document.getElementById('passwordCriteriaList');
            if (existingList) {
                existingList.remove();
            }
            
            if (password) {
                this.insertAdjacentHTML('afterend', feedbackHtml);
            }
            
            toggleSubmitButton();aa
        }, 50);
        
        // Handle confirm password check
        const confirmPassword = document.getElementById('confirmPassword');
        if (confirmPassword.value !== '') {
            confirmPassword.dispatchEvent(new Event('input'));
        }
    });

    // Confirm password validation
    document.getElementById('confirmPassword').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const errorElement = document.getElementById('passwordError');
        
        isPasswordMatch = password === confirmPassword && password !== '';
        
        if (confirmPassword === '') {
            errorElement.className = 'form-text';
            errorElement.textContent = '';
        } else if (isPasswordMatch) {
            errorElement.className = 'form-text text-success';
            errorElement.textContent = 'Passwords match!';
        } else {
            errorElement.className = 'form-text text-danger';
            errorElement.textContent = 'Passwords do not match!';
        }
        
        toggleSubmitButton();
    });

    function resetRegisterForm() {
        document.getElementById('registerForm').reset();
        const firstNameError = document.getElementById('firstNameError');
        const lastNameError = document.getElementById('lastNameError');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const passwordCriteriaList = document.getElementById('passwordCriteriaList');
        
        firstNameError.className = 'form-text';
        firstNameError.textContent = '';
        lastNameError.className = 'form-text';
        lastNameError.textContent = '';
        emailError.className = 'form-text';
        emailError.textContent = '';
        passwordError.className = 'form-text';
        passwordError.textContent = '';
        
        if (passwordCriteriaList) {
            passwordCriteriaList.remove();
        }
        
        isFirstNameValid = false;
        isLastNameValid = false;
        isEmailValid = false;
        isPasswordValid = false;
        isPasswordMatch = false;
        
        Object.keys(passwordCriteria).forEach(key => {
            passwordCriteria[key].met = false;
        });
        
        toggleSubmitButton();
    }

    const modalElement = document.getElementById('registerModal');
    modalElement.addEventListener('show.bs.modal', function() {
        resetRegisterForm();
    });

    // Handle form submission
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (password !== confirmPassword || !isPasswordMatch) {
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Passwords do not match. Please try again.'
            });
            return false;
        }
        const formData = new FormData(this);
        
        fetch('php/register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            // Remove any extra output before JSON
            const jsonStart = text.indexOf('{');
            const jsonText = text.substring(jsonStart);
            
            const data = JSON.parse(jsonText);
            
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message
                }).then(() => {
                    registerModal.hide();
                    // Optional: Reset form
                    this.reset();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Registration failed'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred during registration'
            });
        });
    });
});