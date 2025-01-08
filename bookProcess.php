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
                
                echo "<h2>Book Information</h2>";
                echo "<p>Book Name: $bookName</p>";
                echo "<p>Author: $author</p>";
                echo "<p>Isbn: $isbn</p>";
                echo "<p>Quantity: $quantity</p>";
                echo "<p>Category: $category</p>";
                //validate book name
                if (!preg_match("/^[A-Za-z0-9 ]*$/", $bookName)) {
                    echo "<p>Invalid book name format.</p>";
                }
                //validate author name
                if (!preg_match("/^[A-Za-z ]*$/", $author)) {
                    echo "<p>Invalid author name format.</p>";
                }
                //validate quantity
                if (!preg_match("/^[0-9]*$/", $quantity)) {
                    echo "<p>Invalid quantity format.</p>";
                }
                //validate category
                if (!preg_match("/^[A-Za-z ]*$/", $category)) {
                    echo "<p>Invalid category format.</p>";
                }
                //save book information in the database phpmyadmin
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "webtech";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO books (Name, Author, Isbn, Quantity, Category, Quantity) VALUES ('$bookName', '$author', '$isbn', '$category', '$quantity')";

                if ($conn->query($sql) === TRUE) {
                    echo "<p>New record created successfully</p>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }

                $conn->close();

            }
        ?>
    </div>
</body>
</html>
