<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=4306;dbname=bloodbankdb","mathias","mathias");
} catch( PDOException $err) {
    echo "Database connection problem: " . $err->getMessage();
        exit();
} 
?>
