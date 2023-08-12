<?php include 'navbar.php';
    try {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
                $email = $_SESSION['email'];
                $last_name = $_POST['last_name'];
                $first_name = $_POST['first_name'];
            
                $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email]);

                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
            } else {
                $error_message = "One input is null.";
            }
        }
    } catch(PDOException $err) {
        $pdo->rollBack();
        echo "Exception message: " . $err->getMessage();
        exit();
    }
?>
<title>Edit profile</title>
<?php include 'errorMessage.php'?>
<div class="w-full bg-white mx-auto rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="my-8 space-y-4 md:space-y-6 sm:p-4"> 
        <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Edit Profile
        </h1>
        <form class="text-center space-y-4 md:space-y-6" method="POST">
            <div class="mb-6">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name:</label>   
                <input type="text" id="first_name" name="first_name" value=<?php echo $_SESSION['first_name']; ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="First name" required>
            </div>
            <div class="mb-6">
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name:</label>
                <input type="text" id="last_name" name="last_name" value=<?php echo $_SESSION['last_name']; ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Last name" required>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm edit</button>
        </form>
    </div>
</div>
<?php include 'footer.php';?>