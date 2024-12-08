document.addEventListener('DOMContentLoaded', function() {
    const viewBooksModal = new bootstrap.Modal(document.getElementById('viewBooksModal'));

    // Load books when Edit Books card is clicked
    document.querySelector('[data-bs-target="#viewBooksModal"]').addEventListener('click', function() {
        loadBooks();
    });

    function loadBooks() {
        fetch('php/viewBooks.php')
            .then(response => response.text())
            .then(text => {
                // Find the JSON part of the response
                const jsonStart = text.indexOf('{');
                const jsonString = text.substring(jsonStart);
                const data = JSON.parse(jsonString);
                
                console.log('Received data:', data); // Debug log

                if (data.status === 'success' && data.books) {
                    const tableBody = document.getElementById('booksTableBody');
                    tableBody.innerHTML = '';
                    
                    data.books.forEach(book => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${book.BookTitle}</td>
                            <td>${book.Author}</td>
                            <td>${book.ISBN}</td>
                            <td>${book.Quantity}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editBook('${book.BookId}')">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                    
                    // Show modal after populating data
                    viewBooksModal.show();
                } else {
                    throw new Error(data.message || 'Failed to load books');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load books'
                });
            });
    }

    // Make loadBooks function globally accessible
    window.loadBooks = loadBooks;
});