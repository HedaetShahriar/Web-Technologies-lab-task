<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Borrowoing Management System</title>
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
                <!--show all book from database and use scrawler. -->
            </div>
            <div class="box1">
                <!-- edit book info from database -->
            </div>
            <div class="box2Background">
                <div class="box2">
                <!--load image from a json file-->
                </div>
                <div class="box2">
                <!--load image from a json file-->
                </div>
                <div class="box2">
                <!--load image from a json file-->
                </div>
            </div>
            <div class="boxBook">
                <h4>Book Insertion</h4>
                <form action="bookProcess.php" method="post" class="form">
                    <label for="book">Book Name:</label>
                    <input type="text" name="book" id="book" placeholder="Enter book name" required>
                    <label for="author">Author:</label>
                    <input type="text" name="author" id="author" placeholder="Enter author name" required>
                    <label for="isbn">Isbn:</label>
                    <input type="text" name="isbn" id="isbn" placeholder="Enter isbn" required>
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" placeholder="Enter quantity" required>
                    <label for="category">Category:</label>
                    <input type="category" name="category" id="category" placeholder="Enter category" required>
                    <input type="submit" value="Submit">
                </form>
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
                            <option value="Book1">Book 1</option>
                            <option value="Book2">Book 2</option>
                            <option value="Book3">Book 3</option>
                            <option value="Book4">Book 4</option>
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
            <!--show recently borrowed book. -->
        </div>            
    </div>
</body>
</html>