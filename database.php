<?php

class Database {
    private $connectionObject;
    function openCon() {
        $this->connectionObject = mysqli_connect('localhost', 'root', '', 'webtech');
       //object oriented code to check connection
        if ($this->connectionObject->connect_error) {
            die("Connection failed: " . this->connectionObject->connect_error);
        }
    }
    function addBook($bookName,$author,$isbn,$category,$quantity) {
        $sql = "INSERT INTO `books` (`name`, `author`, `isbn`, `category`, `quantity`) VALUES ('$bookName', '$author', '$isbn', '$category', '$quantity');";
        if (this->connectionObject->query($sql)) {
            return 1;;
        } else {
            return 0;
        }
    }   
    // Show book names
    function showBookName() {
        $sql = "SELECT `name` FROM `books`;";
        
        $result = $this->connectionObject->query($sql);

        return $result;
    }
    function showBook() {
        $sql = "SELECT `name`, `author`, `isbn`, `category`, `quantity` FROM `books`;";
        $result = $this->connectionObject->query($sql);
        return $result;
    }

    // // Show book by ID
    // function showBookById( $pr_id) {
    //     $sql = "SELECT `pr_id`, `p_name`, `p_price`, `p_category`, `p_model` FROM `product` WHERE `pr_id` = $pr_id";
        
    //     // Execute the query
    //     $result = $this->$connectionObject->query($sql);

    //     return $result;
    // }
    function closeCon() {
        $this->connectionObject->close();
    }
}

?>
