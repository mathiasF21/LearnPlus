<?php
    include 'navbar.php';
    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if($_SESSION['status'] === 'gold'){
                $error_message = 'You already are a GOLD member.';
            } elseif($_SESSION['funds'] < 200) {
                $error_message = 'You do not have enough funds to buy GOLD.';
            } else {
                $pdo->beginTransaction(); 
                $newFunds = $_SESSION['funds'] - 200;

                $sql = "UPDATE student SET status = 'gold', funds = :newFunds WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['newFunds' => $newFunds, 'id' => $_SESSION['id']]);
                $pdo->commit(); 

                $_SESSION['status'] = 'gold';
                $success_message = "Thank you! Your are now GOLD.";
            }
        }
    } catch (PDOException $err) {
        $pdo->rollBack(); 
        echo "Exception message: " . $err->getMessage();
        exit();
    }
?>
<title>Gold membership</title>
<?php include 'errorMessage.php'?>
<?php include 'successMessage.php'?>
<body class="flex justify-center items-center h-screen bg-gray-100">
  <div class="text-center my-20">
    <h1 class="text-white text-5xl font-extrabold dark:text-white">LearnPlus<span class="bg-blue-100 bg-yellow-600 text-2xl font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-2">GOLD</span></h1>
    <p class="mb-10 my-4 text-gray-100 dark:text-gray-400">
        LearnPlus Gold subscription offers an exceptional value proposition with its 10% 
        discount on every course. This generous discount empowers subscribers to enjoy 
        significant savings while exploring a diverse range of courses, making continuous 
        learning more affordable and accessible. Whether delving into new subjects or deepening 
        existing knowledge, the 10% discount enriches the LearnPlus experience, encouraging learners 
        to engage more extensively and derive greater value from their educational journey.
    </p>
    <form class="space-y-4 md:space-y-6" method="POST">
        <button type="submit" class="w-9/12 text-white bg-yellow-600 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Become a GOLD member!</button>
    </form>
  </div>
</body>
<?php 
    include 'footer.php';
?>