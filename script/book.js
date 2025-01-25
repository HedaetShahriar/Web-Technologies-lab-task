document.getElementById('bookSubmit').addEventListener('click', function () {
    const bookName = document.getElementById('book').value;
    const author = document.getElementById('author').value;
    const isbn = document.getElementById('isbn').value;
    const quantity = document.getElementById('quantity').value;
    const category = document.getElementById('category').value;

    const invalidBook = document.getElementById('invalidBook');
    const invalidAuthor = document.getElementById('invalidAuthor');
    const invalidIsbn = document.getElementById('invalidIsbn');
    const invalidQuantity = document.getElementById('invalidQuantity');
    let valid = true;

    invalidBook.innerHTML = "";
    invalidAuthor.innerHTML = "";
    invalidIsbn.innerHTML = "";
    invalidQuantity.innerHTML = "";

    const bookNamePattern = /^[A-Z][a-z][A-Za-z0-9\s-]*$/;
    const authorPattern = /^[A-Z][a-z][A-Za-z0-9\s-]*$/;
    const isbnPattern = /^[0-9]{3,10}$/;

    if (bookName === "" || author === "" || isbn === "" || quantity === "" || category === "") {
        alert("All fields are required");
        valid = false;
    }
    if (!bookNamePattern.test(bookName)) {
        invalidBook.innerHTML = "Invalid book name";
        valid = false;
    }
    if (!authorPattern.test(author)) {
        invalidAuthor.innerHTML = "Invalid author name";
        valid = false;
    }
    if (!isbnPattern.test(isbn)) {
        invalidIsbn.innerHTML = "Invalid ISBN";
        valid = false;
    }
    if (quantity <= 0) {
        invalidQuantity.innerHTML = "Quantity must be greater than 0";
        valid = false;
    }
    if (valid) {
        console.log("Sending data:", {
            bookName,
            author,
            isbn,
            quantity,
            category
        });
        //send the data to the server
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "bookProcess.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        const data = `book=${bookName}&author=${author}&isbn=${isbn}&quantity=${quantity}&category=${category}`;
        xhttp.send(data);

        xhttp.onload = function () {
            //alert(xhttp.responseText); // Display server response
            if (xhttp.status === 200) {
                document.getElementById('bookInsertionForm').reset(); // Reset form on success
            }
        };
    }
});
