<?php
    include 'pdo-conn.php';
    try {
        if (isset($_POST['first_name']) && isset($_POST['last_name']) 
        && isset($_POST['email']) && isset($_POST['password']) 
        && isset($_POST['confirm-password']) && isset($_POST['members'])) 
        {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm-password'];
            $email = $_POST['email'];

            $emailCheckSql = "SELECT COUNT(*) FROM users WHERE email = :email";
            $emailCheckStmt = $pdo->prepare($emailCheckSql);
            $emailCheckStmt->execute(['email' => $email]);
            $emailExists = $emailCheckStmt->fetchColumn();

            if ($password !== $confirmPassword) {
                $error_message = "Passwords do not match!";
            } elseif($emailExists) {
                $error_message = "An account with this email already exists.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':first_name' => $_POST['first_name'],
                    ':last_name' => $_POST['last_name'],
                    ':email' => $_POST['email'],
                    ':password' => $hashedPassword
                ));

                $selectionOption = $_POST['members'];
                $userId = $pdo->lastInsertId();

                if($selectionOption === 'ST') {
                    $sql = "INSERT INTO student (id) VALUES (:id)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':id' => $userId));
                } elseif($selectionOption === 'IN') {
                    $sql = "INSERT INTO instructor (id) VALUES (:id)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':id' => $userId));
                } else {
                    $error_message = "Please select a valid option from the dropdown.";
                }
                session_start();
                $_SESSION['id'] = $userId;
                $_SESSION['first_name'] = $_POST['first_name'];
                $_SESSION['last_name'] = $_POST['last_name'];
                $_SESSION['type'] = $_POST['members'];
                $_SESSION['email'] = $_POST['email'];
                header("Location: home.php");
                exit();
            }
        }
        include 'navbar.php' ;

    }  catch( PDOException $err) {
        $pdo->rollBack();
        echo "Exception message: " . $err->getMessage();
            exit();
        }
?>
<title>Sign Up</title>
<?php include 'errorMessage.php'?>
<section class="bg-blue-800 my-44">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="./svgs/mortarboard.svg" alt="logo">
            <span class="text-white">LearnPlus</span>  
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign up
                </h1>
                <form class="space-y-4 md:space-y-6" method="post">
                    <div class="mb-6">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name</label>
                        <input type="text" name="first_name" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name</label>
                        <input type="text" name="last_name" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <div>
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <div>
                    <label for="member_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                        <select id="members" name="members" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Choose your path</option>
                            <option value="ST">Student</option>
                            <option value="IN">Instructor</option>
                        </select>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                        <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                        </div>
                        <div class="ml-3 text-sm">
                        <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-red-700 hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Already have an account? <a href="login.php" class="font-medium text-red-700 hover:underline dark:text-primary-500">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>  
<?php include 'footer.php';?>