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

    // Password validation
    document.getElementById('loginPassword').addEventListener('input', function () {
        const password = this.value;
        isPasswordValid = password.length >= 6;
    });

    // Form submission
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();

        if (!isEmailValid || !isPasswordValid) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please check your email and password'
            });
            return;
        }

        const formData = new FormData(this);

        fetch('php/login.php', {
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
                    sessionStorage.setItem('firstName', data.user.firstName);
                    sessionStorage.setItem('role', data.user.role);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message
                    }).then(() => {
                        loginModal.hide();
                        if (data.user.role === 'Admin') {
                            window.location.href = 'dashboard.html';
                        } else if ((data.user.role === 'Student')){
                            window.location.href = 'student.html';
                        }else  {
                            window.location.href = 'admin.html';
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