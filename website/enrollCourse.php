<?php
    include 'navbar.php';
    try {
        if (isset($_POST['course_id'])) {

            $user_id = $_SESSION['id'];
            $funds = $_SESSION['funds'];
            $course_id = (int)$_POST['course_id'];
    
            $sql = 'SELECT * FROM Course WHERE id = :course_id';
            $stmtCourse = $pdo->prepare($sql); 
            $stmtCourse->bindParam(':course_id', $course_id, PDO::PARAM_INT);
            $stmtCourse->execute();
            
            if ($stmtCourse->rowCount() > 0) {
                $course = $stmtCourse->fetch(PDO::FETCH_ASSOC);
                $id_instructor = $course['id_instructor'];
                $cost = $course['cost'];
    
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

                    $_SESSION['funds'] = $new_funds;
                } else {
                    $error_message = "You do not have enough funds to buy this course.";
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
<title>Course conlusion</title>
<?php if (!empty($error_message)) : ?>
    <div id="alert-border-2" class="flex items-center p-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div class="ml-3 text-sm font-medium">
            <h1 class="font-medium text-red-800"><?php echo $error_message; ?></h1>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
        <span class="sr-only">Dismiss</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
        </button>
    </div>
<?php endif; ?>
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
                        <option value="SC">Enroll</option>
                        <option value="MT">Delist</option>
                    </select>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Delist/Enroll</button>
        </form>
    </div>
</div>
<?php include 'footer.php';?>