<?php
    include 'navbar.php';
?>
<title>Home</title>
<div class="relative h-screen bg-blue-700 bg-cover bg-center" style="background-image: url('./images/learning.jpg');">
    <div class="absolute top-0 left-0 w-full h-full bg-blue-700 opacity-70"></div>
    <div class="relative h-full flex flex-col justify-center items-center text-center">
        <h1 class="relative z-10 text-4xl font-bold tracking-tight text-white sm:text-6xl">Empower Your Mind: Learn, Grow, Succeed!</h1>
        <p class="mt-6 text-lg leading-8 text-gray-300">Discover a World of Knowledge: Explore, Learn, and Grow with Our Interactive Learning Platform. Whether you're a curious beginner or a seasoned enthusiast, our diverse range of courses awaits you.</p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
        <?php
            if (isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];

                $studentSql = 'SELECT * FROM Student WHERE id = :id';
                $instructorSql = 'SELECT * FROM Instructor WHERE id = :id';
                
                $stmtSt = $pdo->prepare($studentSql);
                $stmtSt->bindParam(':id', $user_id, PDO::PARAM_INT);
                $stmtSt ->execute();

                $stmtT = $pdo->prepare($instructorSql);
                $stmtT ->bindParam(':id', $user_id, PDO::PARAM_INT);
                $stmtT ->execute();
                
                if($stmtSt->rowCount() > 0) {
                    $studentData = $stmtSt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['funds'] = $studentData['funds']; 
                    echo '<a href="enrollCourse.php" class="rounded-md bg-red-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Enroll in a course</a>';
                    echo '<a href="gold.php" class="rounded-md bg-yellow-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Become GOLD!</a>';
                } elseif($stmtT->rowCount() > 0) {
                    echo '<a href="insertCourse.php" class="rounded-md bg-red-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create a course</a>';
                }
            } else {
                echo '<a href="auth.php" class="rounded-md bg-red-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">I want to learn/teach</a>';
            }
        ?>
            <a href="learnMore.php" class="text-sm font-semibold hover:underline leading-6 text-white">Learn more <span aria-hidden="true">→</span></a>
        </div>
    </div>
</div>
<h1 class="my-5 text-center relative z-10 text-4xl font-bold tracking-tight text-white sm:text-6xl"><span class="underline decoration-red-700">What can you learn or teach?</span></h1>
<div class="max-w-6xl mx-auto">
    <div class="flex flex-wrap text-center gap-4">
        <div class="border-white border-4 bg-teal-900 h-20 flex-1 h-96 rounded-xl flex flex-col items-center justify-center">
            <img class="w-20 h-20 mx-auto" src="./svgs/history.svg" alt="logo"> 
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">History</h1>
            <div class="space-x-6 mt-4"> 
                <a href="history.php" class="rounded-md bg-orange-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Learn/Teach History</a>
            </div>      
        </div>  
        <div class="border-white border-4 bg-teal-300 h-20 flex-1 h-96 rounded-xl flex flex-col items-center justify-center"> 
            <img class="w-20 h-20 mx-auto" src="./svgs/math.svg" alt="logo"> 
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Math</h1>
            <div class="space-x-6 mt-4"> 
                <a href="math.php" class="rounded-md bg-orange-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Learn/Teach Math</a>
            </div>      
        </div>  
        <div class="border-white border-4 bg-cyan-600 h-20 flex-1 h-96 rounded-xl flex flex-col items-center justify-center">
            <img class="w-20 h-20 mx-auto" src="./svgs/science.svg" alt="logo"> 
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Science</h1>
            <div class="space-x-6 mt-4"> 
                <a href="science.php" class="rounded-md bg-orange-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Learn/Teach Science</a>
            </div>      
        </div>  
        <div class="border-white border-4 bg-indigo-600 h-20 flex-1 h-96 rounded-xl flex flex-col items-center justify-center">
            <img class="w-20 h-20 mx-auto" src="./svgs/flag.svg" alt="logo"> 
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">English</h1>
            <div class="space-x-6 mt-4"> 
                <a href="english.php" class="rounded-md bg-orange-600 px-10 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Learn/Teach English</a>
            </div>      
        </div>
    </div>
</div>
<h1 class="my-5 text-center relative z-10 text-4xl font-bold tracking-tight text-white sm:text-6xl"><span class="underline decoration-red-700">Customer reviews</span></h1>
<div>
    <figure class="max-w-screen-md my-7 mx-7">
        <div class="flex items-center mb-4 text-yellow-300">
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
        </div>
        <blockquote>
            <p class="text-2xl font-semibold text-white dark:text-white">"LearnPlus has been a lifesaver on my journey to mastering this challenging subject. The platform's intuitive interface and interactive lessons have made complex concepts easier to understand."</p>
        </blockquote>
        <figcaption class="flex items-center mt-6 space-x-3">
            <img class="w-6 h-6 rounded-full" src="./images/review_2.jpg" alt="profile picture">
            <div class="flex items-center divide-x-2 divide-gray-300 dark:divide-gray-700">
                <cite class="pr-3 font-medium text-white dark:text-white">James Green</cite>
                <cite class="pl-3 text-sm text-gray-300 dark:text-gray-400">Mathematics learner</cite>
            </div>
        </figcaption>
    </figure>
    <figure class="max-w-screen-md ml-3 float-right">
        <div class="flex items-center mb-4 text-yellow-300 ml-auto">
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
        </div>
        <blockquote>
            <p class="text-2xl font-semibold text-white dark:text-white">"As a science teacher, I must say it has been a game-changer in the world of science education. From the very first day I started using it, I was amazed by the seamless integration of cutting-edge technology and innovative educational tools."</p>
        </blockquote>
        <figcaption class="flex items-center mt-6 space-x-3">
            <img class="w-6 h-6 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png" alt="profile picture">
            <div class="flex items-center divide-x-2 divide-gray-300 dark:divide-gray-700">
                <cite class="pr-3 font-medium text-white dark:text-white">William Smith</cite>
                <cite class="pl-3 text-sm text-gray-300 dark:text-gray-400">Science instructor</cite>
            </div>
        </figcaption>
    </figure>
    <figure class="max-w-screen-md my-7 mx-7">
        <div class="flex items-center mb-4 text-yellow-300">
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
        </div>
        <blockquote>
            <p class="text-2xl font-semibold text-white dark:text-white">"I couldn't be more delighted with the impact LearnPlus has had on my classroom. This platform has breathed new life into my teaching methods and transformed the way my students engage with the English language."</p>
        </blockquote>
        <figcaption class="flex items-center mt-6 space-x-3">
            <img class="w-6 h-6 rounded-full" src="./images/review_1.jpg" alt="profile picture">
            <div class="flex items-center divide-x-2 divide-gray-300 dark:divide-gray-700">
                <cite class="pr-3 font-medium text-white dark:text-white">Anna Gates</cite>
                <cite class="pl-3 text-sm text-gray-300 dark:text-gray-400">English instructor</cite>
            </div>
        </figcaption>
    </figure>
</div>
<?php include 'footer.php';?>


