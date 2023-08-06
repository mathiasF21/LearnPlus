<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=bloodbankdb","mathias","mathias");
} catch( PDOException $err) {
    echo "Database connection problem: " . $err->getMessage();
        exit();
} 
?>
