<?php
    $sql = 'SELECT inscription.grade, users.id, users.first_name, users.last_name, inscription.id_course, course.name
                        FROM inscription
                        JOIN users ON inscription.id_student = users.id
                        JOIN course ON inscription.id_course = course.id
                        WHERE inscription.id_instructor = :id';
    $stmt = $pdo->prepare($sql);
    $stmt ->bindParam(':id',  $_SESSION['id'], PDO::PARAM_INT);
    $stmt ->execute();
?>