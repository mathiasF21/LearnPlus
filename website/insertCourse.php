<?php
    include 'pdo-conn.php';
    include 'navbar.php';
    $_SESSION['courses_created'] = true;
    try {
        if (isset($_POST['course_name']) && isset($_POST['course_desc']) 
        && isset($_POST['max-cap']) && isset($_POST['start-time']) 
        && isset($_POST['end-time']) && isset($_POST['course_choice'])
        && isset($_POST['cost'])) {

            $course_name = htmlspecialchars($_POST['course_name']);
            $max_capacity = (int)$_POST['max-cap'];
            $course_desc = htmlspecialchars($_POST['course_desc']);
            $course_choice = $_POST['course_choice'];
            $category_id = null;
            $start_time = $_POST['start-time'];
            $end_time = $_POST['end-time'];
            $course_cost = $_POST['cost'];

            if ($course_choice === 'SC') {
                $category_id = 1;
            } elseif ($course_choice === 'MT') {
                $category_id = 2;
            } elseif ($course_choice === 'HS') {
                $category_id = 4;
            } elseif ($course_choice === 'EN') {
                $category_id = 3;
            } else {
                $_POST['errorMessage'] = "Please select a valid option from the dropdown.";
                header("Location insertCourse.php");
            }

            $sqlSearch = "SELECT * FROM course WHERE id_instructor = :id_instructor AND name = :name";
            $stmtInscription = $pdo->prepare($sqlSearch);
            $stmtInscription->bindParam(':id_instructor', $_SESSION['id'], PDO::PARAM_INT);
            $stmtInscription->bindParam(':name', $course_name, PDO::PARAM_INT);
            $stmtInscription->execute();

            if($stmtInscription->rowCount() > 0) {
                $error_message = "You have already created a course with this name.";
            } else {
                $sql = "INSERT INTO course (id_instructor, id_category, description, name, start_time, end_time, max_capacity, cost) VALUES (:id_instructor, :id_category, :description, :name, :start_time, :end_time, :max_capacity, :cost)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':id_instructor' => $_SESSION['id'],
                    ':id_category' => $category_id,
                    ':description' => $course_desc,
                    ':name' => $course_name,
                    ':start_time' => $start_time,
                    ':end_time' => $end_time,
                    ':max_capacity' => $max_capacity,
                    'cost' => $course_cost
            ));
            $success_message = "Course created!";
            }
        } elseif(isset($_POST['id_course']) && isset($_POST['price'])) {

            $id_course = $_POST['id_course'];
            $price = $_POST['price'];

            // Deleting the course
            $delete_course_sql = "DELETE FROM Course WHERE id = :id_course";
            $delete_course_stmt = $pdo->prepare($delete_course_sql);
            $delete_course_stmt->bindParam(':id_course', $id_course, PDO::PARAM_INT);
            $delete_course_stmt->execute();

            // Selecting student IDs
            $select_student_ids_sql = "SELECT id_student FROM Inscription WHERE id_course = :course_id";
            $select_student_ids_stmt = $pdo->prepare($select_student_ids_sql);
            $select_student_ids_stmt->bindParam(':course_id', $id_course, PDO::PARAM_INT);
            $select_student_ids_stmt->execute();
            $student_ids = $select_student_ids_stmt->fetchAll(PDO::FETCH_COLUMN);

            // Updating student funds
            foreach($student_ids as $student_id) {
                $update_student_funds_sql = "UPDATE student SET funds = funds + :price WHERE id = :student_id";
                $update_student_funds_stmt = $pdo->prepare($update_student_funds_sql);
                $update_student_funds_stmt->bindParam(':price', $price, PDO::PARAM_INT); 
                $update_student_funds_stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT); 
                $update_student_funds_stmt->execute();
            }

            // Deleting course inscriptions
            $delete_inscriptions_sql = "DELETE FROM Inscription WHERE id_course = :id_course";
            $delete_inscriptions_stmt = $pdo->prepare($delete_inscriptions_sql);
            $delete_inscriptions_stmt->bindParam(':id_course', $id_course, PDO::PARAM_INT);
            $delete_inscriptions_stmt->execute();
        }
    } catch(PDOException $err) {
        $pdo->rollBack();
        echo "Exception message: " . $err->getMessage();
        exit();
    }
?>
<title>Insert a course</title>
<?php include 'errorMessage.php'?>
<?php include 'successMessage.php'?>

<div class="mx-auto w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="my-7 p-6 space-y-4 md:space-y-6 sm:p-8">
    <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Create your course
    </h1>
        <form class="space-y-4 md:space-y-6" method="POST">
            <div class="mb-6">
                <label for="course_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course name:</label>
                <input type="text" name="course_name" id="course_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="mb-6">   
                <label for="course_desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course description:</label>
                <textarea id="course_desc" name="course_desc" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
            </div>
            <div>
                <label for="max-cap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Maximum capacity:</label>
                <input type="number" name="max-cap" id="max-cap" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required step="1">
            </div>
            <div>
                <label for="cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course cost:</label>
                <input type="number" name="cost" id="cost" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required step="1">
            </div>
            <div>
                <label for="course_choice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose the subject:</label>
                    <select id="course_choice" name="course_choice" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose your path</option>
                        <option value="SC">Science</option>
                        <option value="MT">Mathematics</option>
                        <option value="HS">History</option>
                        <option value="EN">English</option>
                    </select>
            </div>
            <div>
                <label for="start-time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Time (HH:mm):</label>
                <input type="time" name="start-time" id="start-time" class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                
                <label for="end-time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Time (HH:mm):</label>
                <input type="time" name="end-time" id="end-time" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create a course</button>
        </form>
    </div>
</div>
<h1 class="mx-5 relative my-4 text-center z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl"><span class="underline decoration-red-600">Created courses</span></h1>';
<?php include 'tableCourse.php'?>
<?php include 'footer.php';?>