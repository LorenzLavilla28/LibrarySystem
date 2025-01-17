document.addEventListener('DOMContentLoaded', function () {
    // Initialize variables
    let isEmailValid = false;
    let isPasswordValid = false;
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));

    // Function to reset form
    function resetLoginForm() {
        document.getElementById('loginForm').reset();
        const emailError = document.getElementById('loginEmailError');
        if (emailError) {
            emailError.className = 'form-text';
            emailError.textContent = '';
        }
        isEmailValid = false;
        isPasswordValid = false;
    }

    // Email validation
    document.getElementById('loginEmail').addEventListener('input', function () {
        const email = this.value;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        isEmailValid = emailPattern.test(email);
    });


    // Form submission
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();
    
        const formData = new FormData(this);
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
    
        fetch('php/login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            const jsonStart = text.indexOf('{');
            const jsonText = text.substring(jsonStart);
            const data = JSON.parse(jsonText);
    
            if (data.status === 'success') {
                // Store user data
                sessionStorage.setItem('user_id', data.user.id);
                sessionStorage.setItem('firstName', data.user.firstName);
                sessionStorage.setItem('lastName', data.user.lastName);
                sessionStorage.setItem('email', data.user.email);
                sessionStorage.setItem('role', data.user.role);
            
                // Show success message and redirect
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message
                }).then(() => {
                    loginModal.hide();
                    // Check role for redirection
                    if (data.user.role === 'superadmin') {
                        window.location.href = 'admin.html';
                    } else {
                        window.location.href = 'landing.html';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred during login'
            });
        });
    });
    window.logout = function () {
        fetch('php/logout.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Logged out successfully'
                    }).then(() => {
                        // Reset navbar to default state
                        const navbarNav = document.getElementById('navbarNav');
                        navbarNav.innerHTML = `
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="#" class="btn btn-outline-light me-2 btn-custom" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="btn btn-success btn-custom" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                                </li>
                            </ul>
                        `;
                        window.location.reload(); // Refresh page
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during logout'
                });
            });
    };
    // Add modal reset handler
    const modalElement = document.getElementById('loginModal');
    modalElement.addEventListener('show.bs.modal', function () {
        resetLoginForm();
    });
});