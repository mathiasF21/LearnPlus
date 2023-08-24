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

                if(!empty($idCourses)) {
                    $inClause = implode(',', array_fill(0, count($idCourses), '?'));
                    $stmt = $pdo->prepare("SELECT id, id_instructor, description, name, start_time, end_time, max_capacity, cost FROM Course WHERE id IN ($inClause)");
                    foreach ($idCourses as $index => $id) {
                        $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
                    }
                    $stmt->execute();
                }       
            } elseif($_SESSION['courses_created']) {
                $stmt = $pdo->prepare("SELECT id, id_instructor, description, name, start_time, end_time, max_capacity, cost FROM Course WHERE id_instructor = :id_instructor");
                $stmt->bindParam(':id_instructor', $_SESSION['id'], PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $stmt = $pdo->prepare("SELECT id, id_instructor, description, name, start_time, end_time, max_capacity, cost FROM Course WHERE id_category = :id_category");
                $stmt->bindParam(':id_category', $_SESSION['category_id'], PDO::PARAM_INT);
                $stmt->execute();
            }
            if(isset($stmt)) {
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
                    if (isset($_SESSION['type']) && $_SESSION['type'] === 'ST' && $_SESSION['status'] === 'gold') {
                        $discountedCost = $row['cost'] * 0.9;
                        echo $discountedCost . ' CAD';
                    } else {
                        echo $row['cost'] . ' CAD';
                    }
                    echo '</td>';
                    echo '<td class="px-6 py-4">';
                    if ($_SESSION['courses_created']) {
                        echo '<form method="POST">';
                        echo '<input type="hidden" name="price" id="price" value="' . $row['cost'] . '">';
                        echo '<input type="hidden" name="id_course" id="id_course" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>';
                        echo '</form>';
                    } else {
                        echo $row['id'];
                    }
                    echo '</td>';
                    echo '<td class="px-6 py-4 text-right">';
                    echo '<a href="description.php?course_id=' . $row['id'] . '" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View description</a>';
                    echo '</td></tr>';
                }
                echo '</tbody>';
            } else {
                echo '<div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">';
                echo '<svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">';
                echo '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>';
                echo '</svg>';
                echo '<span class="sr-only">Info</span>';
                echo '<div>';
                echo 'No courses yet.';
                echo '</div>';
            }
        ?>            
    </table>
</div>