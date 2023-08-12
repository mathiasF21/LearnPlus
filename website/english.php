<?php
    include 'navbar.php';
    $_SESSION['category_id'] = 3;
    $_SESSION['mycourses'] = false;
?>
<title>English</title>
<div>
    <h1 class="text-center mx-5 relative my-4 z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl">English courses</h1>
</div>
<?php include 'tableCourse.php' ?>
<div class="my-9 py-3 bg-red-700">
    <h1 class=" mx-5 relative my-4 z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl"><span class="underline decoration-blue-600">Why study English?</span></h1>
    <p class="mx-5 my-4 mt-6 text-2xl leading-8 text-gray-100">
        English is the most widely spoken language globally, and it serves as a lingua franca 
        in many international settings. It is the language of business, science, diplomacy, and 
        the internet, making it essential for communication across borders. English is often the 
        language used in the technology and innovation sectors. Being proficient in English can 
        help you keep up with the latest advancements and participate in online communities.
    </p>
</div>

<?php include 'footer.php';?>