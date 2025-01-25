<!DOCTYPE html>
<html lang="en">
<head>
    <title>Process</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <div class="process">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Sanitize input
                $bookName = htmlspecialchars($_POST["book"]);
                $author = htmlspecialchars($_POST["author"]);
                $isbn = htmlspecialchars($_POST["isbn"]);
                $quantity = htmlspecialchars($_POST["quantity"]);
                $category = htmlspecialchars($_POST["category"]);
                
                //save book information in the database phpmyadmin
                $conn = mysqli_connect('localhost', 'root', '', 'book_borrow_system');
                // Check the connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                // Insert data into the database
                $sql = "INSERT INTO `book`(`book_name`, `author_name`, `isbn`, `quantity`, `category`) VALUES ('$bookName', '$author', '$isbn', '$quantity', '$category')";
                if (mysqli_query($conn, $sql)) {
                    echo "Registration Accepted<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                // Close the connection
                mysqli_close($conn);
            }
        ?>
    </div>
</body>
</html>
