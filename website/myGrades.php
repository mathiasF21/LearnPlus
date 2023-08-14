<?php 
    include 'navbar.php' ;
?>
    <h1 class="mx-5 relative my-4 text-center z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl"><span class="underline decoration-red-600">My grades</span></h1>';
    <div class="w-11/12 mx-auto relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    COURSE
                </th>
                <th scope="col" class="px-6 py-3">
                    GRADE
                </th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
                $sql = 'SELECT grade, course.name
                FROM inscription
                JOIN course ON inscription.id_course = course.id
                WHERE inscription.id_student = :id';
                $stmt = $pdo->prepare($sql);
                $stmt ->bindParam(':id',  $_SESSION['id'], PDO::PARAM_INT);
                $stmt ->execute();
            
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
                    echo '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
                    echo $row['name'];
                    echo '</th>';
                    echo '<td class="px-6 py-4">';
                    echo $row['grade'];
                    echo '</td>';
                    echo '</tr>';
                }
            ?>            
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>