<?php 
    include 'navbar.php';
    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_grade']) && isset($_POST['student_id'])) {
            $new_grade = $_POST['new_grade'];
            $student_id = $_POST['student_id'];
    
            $sql = "UPDATE inscription SET grade = :new_grade WHERE id_student = :id_student";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':id_student' => $student_id,
                ':new_grade' => $new_grade
            ));
        }
    } catch(PDOException $err) {
        echo "Exception message: " . $err->getMessage();
        exit();
    }
?>
<h1 class="mx-5 relative my-4 text-center z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl"><span class="underline decoration-red-600">My students</span></h1>
<div class="w-11/12 mx-auto relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    STUDENT'S NAME
                </th>
                <th scope="col" class="px-6 py-3">
                    COURSE
                </th>
                <th scope="col" class="px-6 py-3">
                    GRADE
                </th>
                <th scope="col" class="px-6 py-3">
                    NEW GRADE
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only"></span>
                </th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
                include 'myStudentsPrepare.php';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
                    echo '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
                    echo $row['first_name'] . ' ' . $row['last_name'];
                    echo '</th>';
                    echo '<td class="px-6 py-4">';
                    echo $row['name'];
                    echo '</td>';
                    echo '<td class="px-6 py-4">';
                    echo $row['grade']; 
                    echo '</td>';
                    echo '<td class="px-6 py-4">';
                    echo '<form method="POST">';
                    echo '<input type="hidden" name="student_id" value=' . $row['id'] . '>';
                    echo '<input type="number" name="new_grade" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required step="0.01">';
                    echo '</td>';
                    echo '<td class="px-6 py-4 text-right">';
                    echo '<button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Submit grade</button>';
                    echo '</form>';
                    echo '</td></tr>';
                }
            ?>            
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
