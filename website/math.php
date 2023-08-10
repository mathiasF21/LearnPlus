<?php
    include 'navbar.php' ;
    $_SESSION['category_id'] = 2;
?>
<title>Mathematics</title>
<div>
    <h1 class="text-center mx-5 relative my-4 z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl">Mathematics courses</h1>
</div>
<?php include 'tableCourse.php' ?>
<div class="my-9 py-3 bg-red-700">
    <h1 class=" mx-5 relative my-4 z-10 text-4xl font-bold tracking-tight text-white sm:text-4xl"><span class="underline decoration-blue-600">Why study Mathematics?</span></h1>
    <p class="mx-5 my-4 mt-6 text-2xl leading-8 text-gray-100">
        Math teaches critical thinking and problem-solving skills. It equips individuals with the 
        ability to analyze and solve complex problems logically, which is valuable in various 
        fields and everyday life. Math is a language of patterns and relationships that underlie 
        various phenomena in the world. It helps us comprehend natural phenomena, economic trends, 
        and scientific principles.
    </p>
</div>

<?php include 'footer.php';?>