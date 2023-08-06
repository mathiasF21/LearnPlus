<?php
    require_once('base.php');
    session_start();
?>
<body class="bg-blue-800">
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
            <a href="home.php" class="flex items-center">
                <img src="./svgs/mortarboard.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">LearnPlus</span>
            </a>
            <div class="flex items-center">
                <a href="#" class="mr-6 text-sm  text-gray-500 dark:text-white hover:underline">(123) 456-7891</a>
                <?php
                    if(isset($_SESSION['email'])) {
                        echo '<a href="logout.php" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">Logout</a>';
                    } else {
                        echo '<a href="login.php" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">Login</a>';
                    }
                ?>
            </div>
        </div>
    </nav>
    <nav class="bg-gray-50 dark:bg-gray-700">
        <div class="max-w-screen-xl px-4 py-3 mx-auto bg-red-700">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 mr-6 space-x-8 text-sm">
                    <li>
                        <a href="home.php" class="text-white dark:text-white hover:underline" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="aboutProject.php" class="text-white dark:text-white hover:underline">About project</a>
                    </li>
                    <li>
                        <a href="./studentsInfo.php" class="text-white dark:text-white hover:underline">Learners</a>
                    </li>
                    <li>
                        <a href="./learn_more.php" class="text-white dark:text-white hover:underline">Learn More</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
</body>