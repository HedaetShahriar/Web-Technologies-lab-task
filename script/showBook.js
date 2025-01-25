document.addEventListener('DOMContentLoaded', function () {
    
    
    // Fetch books from the server
    fetch('showbook.php')
        .then(response => response.json())
        .then(data => {
            const booksTableBody = document.querySelector('#booksTable tbody');
            if (data.length > 0) {
                data.forEach(book => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${book.book_name}</td>
                        <td>${book.author_name}</td>
                        <td>${book.isbn}</td>
                        <td>${book.category}</td>
                        <td>${book.quantity}</td>
                    `;
                    booksTableBody.appendChild(row);
                });
            } else {
                booksTableBody.innerHTML = '<tr><td colspan="5">No books available</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching books:', error);
    });
});
