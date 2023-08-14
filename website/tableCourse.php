<div class="w-11/12 mx-auto relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    NAME
                </th>
                <th scope="col" class="px-6 py-3">
                    INSTRUCTOR'S NAME
                </th>
                <th scope="col" class="px-6 py-3">
                    TIME
                </th>
                <th scope="col" class="px-6 py-3">
                    MAX CAPACITY
                </th>
                <th scope="col" class="px-6 py-3">
                    PRICE
                </th>
                <th scope="col" class="px-6 py-3">
                    COURSE ID
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only"></span>
                </th>
            </tr>
        </thead>
        <?php
            echo '<tbody class="text-center">';
            if ($_SESSION['mycourses']) {
                $sqlSearch = "SELECT id_course FROM inscription WHERE id_student = :id_student";
                $stmtInscription = $pdo->prepare($sqlSearch);
                $stmtInscription->bindParam(':id_student', $user_id, PDO::PARAM_INT);
                $stmtInscription->execute();

                $idCourses = $stmtInscription->fetchAll(PDO::FETCH_COLUMN);

                $inClause = implode(',', array_fill(0, count($idCourses), '?'));

                $stmt = $pdo->prepare("SELECT id, id_instructor, description, name, start_time, end_time, max_capacity, cost FROM Course WHERE id IN ($inClause)");
                foreach ($idCourses as $index => $id) {
                    $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
                }
                $stmt->execute();                
            } elseif($_SESSION['courses_created']) {
                $stmt = $pdo->prepare("SELECT id, id_instructor, description, name, start_time, end_time, max_capacity, cost FROM Course WHERE id_instructor = :id_instructor");
                $stmt->bindParam(':id_instructor', $_SESSION['id'], PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $stmt = $pdo->prepare("SELECT id, id_instructor, description, name, start_time, end_time, max_capacity, cost FROM Course WHERE id_category = :id_category");
                $stmt->bindParam(':id_category', $_SESSION['category_id'], PDO::PARAM_INT);
                $stmt->execute();
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $instructorSql = 'SELECT first_name,last_name FROM users WHERE id = :id';
                $stmtT = $pdo->prepare($instructorSql);
                $stmtT ->bindParam(':id', $row['id_instructor'], PDO::PARAM_INT);
                $stmtT ->execute();

                $instructorInfo = $stmtT->fetch(PDO::FETCH_ASSOC);

                echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
                echo '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
                echo $row['name'];
                echo '</th>';
                echo '<td class="px-6 py-4">';
                echo $instructorInfo['first_name'] . ' ' . $instructorInfo['last_name'];
                echo '</td>';
                echo '<td class="px-6 py-4">';
                echo $row['start_time'] . '-' . $row['end_time'];
                echo '</td>';
                echo '<td class="px-6 py-4">';
                echo $row['max_capacity'];
                echo '</td>';
                echo '<td class="px-6 py-4">';
                echo $row['cost'] . ' CAD';
                echo '</td>';
                echo '<td class="px-6 py-4">';
                echo $row['id'];
                echo '</td>';
                echo '<td class="px-6 py-4 text-right">';
                echo '<a href="description.php?course_id=' . $row['id'] . '" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View description</a>';
                echo '</td></tr>';
            }
            echo '</tbody>';
        ?>            
    </table>
</div>