<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'book_borrow_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch book titles
$sql = "SELECT `book_name` FROM `book` WHERE `quantity` > 0"; // Only fetch books in stock
$result = $conn->query($sql);
// Initialize search term and book details
$searchTerm = '';
$books = [];
$message = '';

// Handle search functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchBook'])) {
    $searchTerm =$_POST['searchBook'];

    // Search query
    $sql = "SELECT `id`, `book_name`, `author_name`, `isbn`, `category`, `quantity` 
            FROM `book` 
            WHERE `book_name` LIKE '%$searchTerm%' 
               OR `author_name` LIKE '%$searchTerm%'
               OR `category` LIKE '%$searchTerm%'";
    $result1 = $conn->query($sql);

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $books[] = $row;
        }
    } else {
        $message = 'No books found.';
    }
}

// Handle edit functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editBook'])) {
    $id = ( $_POST['id']);
    $bookName = ( $_POST['book_name']);
    $authorName =($_POST['author_name']);
    $isbn = ( $_POST['isbn']);
    $category = ( $_POST['category']);
    $quantity = ($_POST['quantity']);

    // Update query
    $updateQuery = "UPDATE `book` 
                    SET `book_name`='$bookName', `author_name`='$authorName', `isbn`='$isbn', 
                        `category`='$category', `quantity`='$quantity' 
                    WHERE `id`='$id'";
    if ($conn->query($updateQuery)) {
        $message = 'Book details updated successfully!';
    } else {
        $message = 'Failed to update book details: ' . $conn->error;
    }
    // Redirect to avoid form resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);  // Redirect to the same page
    exit();  // Ensure no further code is executed
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Borrowing Management System</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <img src="./images/ID.png" alt="ID" class="id">
    <div class="background">
        <div class="leftbox">
            <!--Show used tokens-->
            <h3> Used Tokens:</h3>
                    <?php
                        $usedtokens = json_decode(file_get_contents('./json/UsedToken.json'));

                        // Check if tokens are available
                        if ($usedtokens && isset($usedtokens[0]->usedToken)) {
                            echo '<ul>';
                            foreach ($usedtokens[0]->usedToken as $token) {
                                echo '<li>' . $token . '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p>No tokens available.</p>';
                        }
                    ?>
        </div>
        <div class="middlebox">
            <div class="box1">
                <div class="table-container">
                    <table border="1" id="booksTable" class="booktable">
                        <thead>
                            <tr>
                                <th>Book Name</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Category</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded here by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <script src="./script/showBook.js"></script>
            </div>
            <div class="box1">
                    <form method="POST" class="searchForm">
                        <input type="text" name="searchBook" placeholder="Search by book name, author, ISBN, or category" value="<?=  ($searchTerm) ?>" required>
                        <button type="submit">Search</button>
                    </form>

                    <?php if ($message): ?>
                        <p style="color: green;"><?=  ($message) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($books)): ?>
                        <form method="POST">
                            <div class="table-container">
                            <table border="1" id="booksTable1" class="booktable1">
                                <thead>
                                    <tr>
                                        <th>Book Name</th>
                                        <th>Author</th>
                                        <th>ISBN</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($books as $book): ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="id" value="<?= ($book['id']) ?>">
                                                <input type="text" name="book_name" value="<?= ($book['book_name']) ?>" required>
                                            </td>
                                            <td>
                                                <input type="text" name="author_name" value="<?= ($book['author_name']) ?>" required>
                                            </td>
                                            <td>
                                                <input type="text" name="isbn" value="<?=  ($book['isbn']) ?>" required>
                                            </td>
                                            <td>
                                                <input type="text" name="category" value="<?=  ($book['category']) ?>" required>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity" value="<?=  ($book['quantity']) ?>" min="0" required>
                                            </td>
                                            <td>
                                                <button type="submit" name="editBook">Save</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                        </form>
                    <?php elseif ($searchTerm): ?>
                        <p>No books found matching your search.</p>
                    <?php endif; ?>
            </div>
            <div class="box2Background">
                <div class="box2">
                    <img src = "./images/Anna.jpg" alt = "book" class = "book2">
                </div>
                <div class="box2">
                    <img src = "./images/Book2.png" alt = "Book2" class = "book2">
                </div>
                <div class="box2">
                    <img src = "./images/book3.jpg" alt = "Book3" class = "book2">
                </div>
            </div>
            <div class="boxBook">
                <h4>Add Book</h4>
                <form id="bookInsertionForm"  class="form">
                    <label for="book">Book Name:<span id="invalidBook" style="color: red;"></label>
                    <input type="text" name="book" id="book" placeholder="Enter book name" >
                    <label for="author">Author: <span id="invalidAuthor" style="color: red;"></span></label>
                    <input type="text" name="author" id="author" placeholder="Enter author name" >
                    <label for="isbn">Isbn:<span id="invalidIsbn" style="color: red;"></label>
                    <input type="text" name="isbn" id="isbn" placeholder="Enter isbn" >
                    <label for="quantity">Quantity:<span id="invalidQuantity" style="color: red;"></span></label>
                    <input type="number" name="quantity" id="quantity" placeholder="Enter quantity" min="0">
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <option value="">Select a category</option>
                        <option value="Fiction">Fiction</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Biography">Biography</option>
                        <option value="History">History</option>
                        <option value="Others">Others</option>
                    </select>
                    <Button type="button" id="bookSubmit">Submit</Button>
                </form>
                <script src="./script/book.js"></script>
            </div>
            <div class="box3background">
                <div class="box4">
                    <form action="process.php" method="post" class="form">
                        <!--Name-->
                        <label for="name"> Full Name:</label>
                        <input type="text" name="name" id="name" placeholder="Enter your full name" required>
                        <!--ID-->
                        <label for="id"> ID:</label>
                        <input type="text" name="id" id="id" placeholder="Enter your ID" required>
                        <!--Email-->
                        <label for="email"> Email:</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required>
                        <!--Book Title Dropdown-->
                        <label for="book"> Book Title:</label>
                        <select name="book" id="book" required>
                            <option value="">Select a book</option>
                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' .  ($row['book_name']) . '">' .  ($row['book_name']) . '</option>';
                                    }
                                }
                            ?>
                        </select>
                        <!--Borrow Date-->
                        <label for="borrowDate"> Borrow Date:</label>
                        <input type="date" name="borrowDate" id="borrowDate" required>
                        <!--Return Date-->
                        <label for="returnDate"> Return Date:</label>
                        <input type="date" name="returnDate" id="returnDate" required>
                        <!--token-->
                        <label for="token"> Token Number:</label>
                        <input type="text" name="token" id="token">
                        <!--Fees-->
                        <label for="fees"> Fees:</label>
                        <input type="text" name="fees" id="fees" placeholder="0">
                        <!--Submit Button-->
                        <input type="submit" value="Submit">
                    </form>

                </div>
                <div class="box3">
                    <h3>Tokens:</h3>
                    <?php
                        $tokensData = json_decode(file_get_contents('./json/token.json'));

                        // Check if tokens are available
                        if ($tokensData && isset($tokensData[0]->token)) {
                            echo '<ul>';
                            foreach ($tokensData[0]->token as $token) {
                                echo '<li>' . $token . '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p>No tokens available.</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="rightbox">
            <!--edit the book that has been search -->
        </div>            
    </div>
</body>
</html>