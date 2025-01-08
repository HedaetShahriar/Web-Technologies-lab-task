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
                $name = htmlspecialchars($_POST["name"]);
                $id = htmlspecialchars($_POST["id"]);
                $email = htmlspecialchars($_POST["email"]);
                $book = htmlspecialchars($_POST["book"]);
                $borrowDate = htmlspecialchars($_POST["borrowDate"]);
                $returnDate = htmlspecialchars($_POST["returnDate"]);
                $tokenValue = htmlspecialchars($_POST["token"]);
                $fees = htmlspecialchars($_POST["fees"]);

                $bookCookie = str_replace(' ', '_', $book);
                $nameCookie = str_replace(' ', '_', $name);

                $tokenValid = false;
                $tokens = json_decode(file_get_contents('./json/token.json'));
                $usedTokens=json_decode(file_get_contents('./json/UsedToken.json'));

                $isValid = true;
                $errors = [];
                // Name validation
                if (!preg_match("/^(Mr\.|Dr\.|Md\.)?\s?[A-Z][a-z]*(\s[A-Z][a-z]*)*$/", $name)) {
                    $isValid = false;
                    $errors[] = "Invalid name format.";
                }

                // ID validation
                if (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $id)) {
                    $isValid = false;
                    $errors[] = "Invalid ID format. Expected: XX-XXXXX-X";
                }

                // Email validation
                if (!preg_match("/^\d{2}-\d{5}-\d{1}\@student\.aiub\.edu$/", $email)) {
                    $isValid = false;
                    $errors[] = "Invalid email format. Expected: XX-XXXXX-X@student.aiub.edu";
                }

                // Borrow and return date validation
                if (strtotime($returnDate) <= strtotime($borrowDate)) {
                    $isValid = false;
                    $errors[] = "Return date must be greater than borrow date.";
                } elseif ((strtotime($returnDate) - strtotime($borrowDate)) > 10 * 24 * 60 * 60 ) {

                    if ($tokens && isset($tokens[0]->token)) {
                        $tokenList = $tokens[0]->token;
                        $tokenIndex = array_search((int)$tokenValue, $tokenList);
                        
                        if ($tokenIndex !== false) {
                            if (!in_array((int)$tokenValue, $usedTokens[0]->usedToken)) {
                                $tokenValid = true;
                            } 
                        } 
                    } 
                    if(!$tokenValid){
                        $isValid = false;
                        $errors[] = "Return date must be within 10 days of borrow date without a valid token.";
                    }

                }

                // Display errors or valid data
                if (!$isValid) {
                    echo "<div class='errors'>";
                    echo "<ul>";
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    // Set cookie for book with 20s expiry
                    setcookie($bookCookie, $nameCookie, time() + 20, "/");
                    // Check if book is already borrowed
                    if (isset($_COOKIE[$bookCookie])) {
                        echo "<p>Book already borrowed, please wait 20 seconds</p>";
                    } else {
                        //putting the valid token in the
                        if($tokenValid!==false){
                            $usedTokens[0]->usedToken[]= (int)$tokenValue;
                            file_put_contents('./json/UsedToken.json', json_encode($usedTokens, JSON_PRETTY_PRINT));
                        }
                        // Display valid data
                        echo "<p>Name: $name</p>";
                        echo "<p>ID: $id</p>";
                        echo "<p>Email: $email</p>";
                        echo "<p>Book: $book</p>";
                        echo "<p>Borrow Date: $borrowDate</p>";
                        echo "<p>Return Date: $returnDate</p>";
                        echo "<p>Fees: $fees</p>";
                    }
                }
            }
        ?>
    </div>
</body>
</html>
