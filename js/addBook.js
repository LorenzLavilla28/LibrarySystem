document.addEventListener('DOMContentLoaded', function () {
    // Initialize form elements
    const addBookForm = document.getElementById('addBookForm');
    const submitButton = addBookForm.querySelector('button[type="submit"]');
    const titleInput = document.getElementById('title');
    const authorInput = document.getElementById('author');
    const isbnInput = document.getElementById('isbn');
    const quantityInput = document.getElementById('quantity');
    quantityInput.setAttribute('max', '100');
    quantityInput.setAttribute('min', '1');

    // Add pattern attribute to ISBN input
    isbnInput.setAttribute('pattern', '[0-9]{13}');
    isbnInput.setAttribute('maxlength', '13');

    // Validation flags
    let isTitleValid = false;
    let isAuthorValid = false;
    let isISBNValid = false;
    let isQuantityValid = false;
    function resetAddBookForm() {
        addBookForm.reset();
        
        // Reset validation states
        isTitleValid = false;
        isAuthorValid = false;
        isISBNValid = false;
        isQuantityValid = false;

        // Clear validation feedback
        [titleInput, authorInput, isbnInput, quantityInput].forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
            const feedback = input.nextElementSibling;
            if (feedback) {
                feedback.textContent = '';
            }
        });

        toggleSubmitButton();
    }

    // Add modal reset handler
    const modalElement = document.getElementById('addBookModal');
    modalElement.addEventListener('show.bs.modal', function() {
        resetAddBookForm();
    });
    // Updated ISBN validation
    function validateISBN(isbn) {
        const cleaned = isbn.trim();
        const isbnRegex = /^[0-9]{13}$/;
        return isbnRegex.test(cleaned);
    }
    function validateAuthor(author) {
        const authorRegex = /^[A-Za-z\s-]+$/; // Only letters, spaces and hyphens
        return author.trim().length >= 2 && authorRegex.test(author.trim());
    }
    authorInput.addEventListener('input', function () {
        // Remove any numeric characters
        this.value = this.value.replace(/[0-9]/g, '');

        const author = this.value.trim();
        isAuthorValid = validateAuthor(author);

        // Add visual feedback
        if (author === '') {
            this.classList.remove('is-valid', 'is-invalid');
            this.nextElementSibling.textContent = 'Author name is required';
        } else if (author.length < 2) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            this.nextElementSibling.textContent = 'Author name must be at least 2 characters';
        } else if (!isAuthorValid) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            this.nextElementSibling.textContent = 'Author name can only contain letters, spaces and hyphens';
        } else {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
            this.nextElementSibling.textContent = 'Valid author name';
        }

        toggleSubmitButton();
    });
    // Prevent numeric input for author
    authorInput.addEventListener('keypress', function (e) {
        if (/[0-9]/.test(e.key)) {
            e.preventDefault();
        }
    });

    // Prevent paste of numeric characters
    authorInput.addEventListener('paste', function (e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const lettersOnly = pastedText.replace(/[0-9]/g, '');
        this.value = lettersOnly;
    });
    // Input event listeners for ISBN with feedback
    isbnInput.addEventListener('input', function () {
        // Remove any non-numeric characters
        this.value = this.value.replace(/\D/g, '');

        const isbn = this.value.trim();
        isISBNValid = validateISBN(isbn);

        // Add visual feedback
        if (isbn === '') {
            this.classList.remove('is-valid', 'is-invalid');
            this.nextElementSibling.textContent = 'ISBN is required';
        } else if (isbn.length < 13) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            this.nextElementSibling.textContent = `ISBN must be 13 digits (currently: ${isbn.length})`;
        } else if (!isISBNValid) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            this.nextElementSibling.textContent = 'ISBN must contain only numbers';
        } else {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
            this.nextElementSibling.textContent = 'Valid ISBN';
        }

        toggleSubmitButton();
    });
    isbnInput.addEventListener('keypress', function (e) {
        if (!/^\d$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault();
        }
    });
    isbnInput.addEventListener('paste', function (e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const numericOnly = pastedText.replace(/\D/g, '');
        this.value = numericOnly.slice(0, 13);
    });
    // Only allow numeric input for ISBN
    isbnInput.addEventListener('keypress', function (e) {
        if (!/^\d$/.test(e.key)) {
            e.preventDefault();
        }
    });


    // Validation functions
    function validateTitle(title) {
        return title.trim().length >= 2;
    }

    function validateAuthor(author) {
        return author.trim().length >= 2;
    }

    function validateISBN(isbn) {
        const cleaned = isbn.trim().replace(/\D/g, ''); // Remove non-digits
        const isbnRegex = /^[0-9]{13}$/;
        return isbnRegex.test(cleaned);
    }

    function validateQuantity(quantity) {
        const value = parseInt(quantity);
        return value > 0 && value <= 100;
    }

    // Input event listeners
    quantityInput.addEventListener('input', function () {
        const quantity = this.value;
        isQuantityValid = validateQuantity(quantity);

        // Add visual feedback
        if (quantity === '') {
            this.classList.remove('is-valid', 'is-invalid');
            this.nextElementSibling.textContent = 'Quantity is required';
        } else if (quantity > 100) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            this.nextElementSibling.textContent = 'Maximum quantity is 100';
        } else if (quantity < 1) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            this.nextElementSibling.textContent = 'Minimum quantity is 1';
        } else {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
            this.nextElementSibling.textContent = 'Valid quantity';
        }

        toggleSubmitButton();
    });
    quantityInput.addEventListener('keypress', function (e) {
        if (!/^\d$/.test(e.key)) {
            e.preventDefault();
        }
    });
    titleInput.addEventListener('input', function () {
        isTitleValid = validateTitle(this.value);
        toggleSubmitButton();
    });

    authorInput.addEventListener('input', function () {
        isAuthorValid = validateAuthor(this.value);
        toggleSubmitButton();
    });

    isbnInput.addEventListener('input', function () {
        isISBNValid = validateISBN(this.value);
        toggleSubmitButton();
    });

    quantityInput.addEventListener('input', function () {
        isQuantityValid = validateQuantity(this.value);
        toggleSubmitButton();
    });

    function toggleSubmitButton() {
        submitButton.disabled = !(isTitleValid && isAuthorValid && isISBNValid && isQuantityValid);
    }

    // Form submission
    addBookForm.addEventListener('submit', function (event) {
        event.preventDefault();

        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';

        const formData = new FormData(this);

        fetch('php/addBook.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(text => {
                const jsonStart = text.indexOf('{');
                const jsonText = text.substring(jsonStart);
                const data = JSON.parse(jsonText);

                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Book added successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addBookModal'));
                        modal.hide();
                        this.reset();

                        isTitleValid = false;
                        isAuthorValid = false;
                        isISBNValid = false;
                        isQuantityValid = false;
                        toggleSubmitButton();
                    });
                } else {
                    throw new Error(data.message || 'Failed to add book');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'An error occurred while adding the book'
                });
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Add Book';
            });
    });

    // Initial button state
    toggleSubmitButton();
});