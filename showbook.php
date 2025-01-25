<?php
    function fetchBooks() {
        //save book information in the database phpmyadmin
        $conn = mysqli_connect('localhost', 'root', '', 'book_borrow_system');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Query to fetch books
        $sql = "SELECT `book_name`, `author_name`, `isbn`, `quantity`, `category` FROM `book`"; // Replace 'books' with your table name.
        $books = $conn->query($sql);
        
        $bookArray = []; // Initialize an empty array.
        
        if ($books->num_rows > 0) {
            while ($row = $books->fetch_assoc()) {
                $bookArray[] = $row; // Collect each book row.
            }
        }
        
        // Return JSON encoded data
        header('Content-Type: application/json'); // Set the content type to JSON.
        echo json_encode($bookArray);
        
        // Close connection
        $conn->close();
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        fetchBooks();
    }
?>