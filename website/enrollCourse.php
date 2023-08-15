<?php
    include 'navbar.php';
    $_SESSION['mycourses'] = true;
    try {
        if (isset($_POST['course_id']) && isset($_POST['course_conclusion'])) {

            $user_id = $_SESSION['id'];
            $funds = $_SESSION['funds'];
            $course_id = (int)$_POST['course_id'];
            $optionSelected = $_POST['course_conclusion'];
    
            $sql = 'SELECT * FROM Course WHERE id = :course_id';
            $stmtCourse = $pdo->prepare($sql); 
            $stmtCourse->bindParam(':course_id', $course_id, PDO::PARAM_INT);
            $stmtCourse->execute();
            
            if ($stmtCourse->rowCount() > 0) {
                $course = $stmtCourse->fetch(PDO::FETCH_ASSOC);
                $id_instructor = $course['id_instructor'];
                
                if($_SESSION['status'] === 'gold') {
                    $cost = $course['cost'] * 0.9;
                } else {
                    $cost = $course['cost'];
                }
                
                if($optionSelected === 'EN') {
                    if ($cost <= $funds) {
                        $sqlInsert = "INSERT INTO inscription (id_student, id_course, id_instructor) VALUES (:id_student, :id_course, :id_instructor)";
                        $stmtInsert = $pdo->prepare($sqlInsert); 
                        $stmtInsert->execute(array(
                            ':id_student' => $user_id,
                            ':id_course' => $course_id,
                            ':id_instructor' => $id_instructor));
    
                        $sql = "UPDATE Student SET funds = :funds - :cost WHERE id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':funds' => $funds, ':cost' => $cost, 'id' => $user_id]);
    
                        $sqlUpdate = "UPDATE Student SET funds = :new_funds WHERE id = :id";
                        $new_funds = $funds - $cost;
                        $stmtUpdate = $pdo->prepare($sqlUpdate);
                        $stmtUpdate->execute([':new_funds' => $new_funds, 'id' => $user_id]);

                        $success_message = "Enrolled in successfully!"; 
    
                        $_SESSION['funds'] = $new_funds;
                    } else {
                        $error_message = "You do not have enough funds to buy this course.";
                    }
                } elseif ($optionSelected === 'DE') {
                    $sqlSearch = "SELECT * FROM inscription WHERE id_student = :id_student AND id_course = :id_course";
                    $stmtInscription = $pdo->prepare($sqlSearch);
                    $stmtInscription->bindParam(':id_student', $user_id, PDO::PARAM_INT);
                    $stmtInscription->bindParam(':id_course', $course_id, PDO::PARAM_INT);
                    $stmtInscription->execute();
                
                    if ($stmtInscription->rowCount() > 0) { 
                        $sqlDelete = "DELETE FROM inscription WHERE id_student = :id_student AND id_course = :id_course";
                        $stmtDelete = $pdo->prepare($sqlDelete);
                        $stmtDelete->execute(array(
                            ':id_course' => $course_id,
                            ':id_student' => $user_id
                        ));
                    
                        $sqlUpdate = "UPDATE student SET funds = funds + :refund WHERE id = :id_student";
                        $stmtUpdate = $pdo->prepare($sqlUpdate);
                        $stmtUpdate->execute(array(
                            ':refund' => $cost,
                            ':id_student' => $user_id
                        ));

                        $success_message = "Delisted from the course successfully!";
                    } else {
                        $error_message = "You are not in this course";
                    }
                }
            } else {
                $error_message = "Course ID not found.";
            }
        }
    } catch( PDOException $err) {
        $pdo->rollBack();
        echo "Exception message: " . $err->getMessage();
        exit();
    }
?>
<title>Course Conclusion</title>
<?php include 'errorMessage.php'?>
<?php include 'successMessage.php'?>
<div class="w-full bg-white mx-auto rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="my-8 space-y-4 md:space-y-6 sm:p-4"> 
        <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Enroll/Delist a course
        </h1>
        <form class="text-center space-y-4 md:space-y-6" method="post">
            <div class="mb-6">
                <label for="course_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course ID</label>
                <input type="number" id="course_id" name="course_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Insert course ID" required>
            </div>
            <div>
                <label for="course_conclusion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course action:</label>
                    <select id="course_conclusion" name="course_conclusion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose one option</option>
                        <option value="EN">Enroll</option>
                        <option value="DE">Delist</option>
                    </select>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Delist/Enroll</button>
        </form>
    </div>
</div>
<h1 class="mx-5 relative my-4 text-center z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl"><span class="underline decoration-red-600">My courses</span></h1>';
<?php include 'tableCourse.php'?>
<?php include 'footer.php';?>