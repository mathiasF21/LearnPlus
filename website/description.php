<?php
    include 'navbar.php';
    $courseId = $_GET['course_id'];

    $stmt = $pdo->prepare("SELECT name,description FROM Course WHERE id = :id");
    $stmt->bindParam(':id', $_GET['course_id'], PDO::PARAM_INT);
    $stmt->execute();

    $courseInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="my-9 py-3 bg-red-700">';
    echo '<h1 class=" mx-5 relative my-4 z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl"><span class="underline decoration-blue-600">' . $courseInfo['name']  . '</span></h1>';
    echo '<p class="mx-5 my-4 mt-6 text-2xl leading-8 text-gray-100">';
    echo $courseInfo['description'];
    echo '</p>';
    echo '</div>';
?>
<title>Course Description</title>
<?php include 'footer.php';?>