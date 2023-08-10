<?php
    require_once('pdo-conn.php');
    try {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {

            $email = $_POST['email'];
            $password= $_POST['password'];
            $confirm_password = $_POST['confirm-password'];

            if ($password !== $confirm_password) {
                $error_message = 'Passwords do not match!';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = :password WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['password' => $hashedPassword, 'email' => $email]);

                if($stmt->rowCount() > 0) {
                    header("Location: changePassword.php");
                    exit();
                } else {
                    $error_message = 'Email not found';
                }
            }
        }
    }
    catch( PDOException $err) {
        $pdo->rollBack();
        echo "Exception message: " . $err->getMessage();
            exit();
        }
    include 'navbar.php' ;
?>
<title>Password Change</title>
<section class="bg-blue-800">
<?php if (!empty($error_message)) : ?>
    <div id="alert-border-2" class="flex items-center p-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div class="ml-3 text-sm font-medium">
            <h1 class="font-medium text-red-800"><?php echo $error_message; ?></h1>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
        <span class="sr-only">Dismiss</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
        </button>
    </div>
<?php endif; ?>
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="w-8 h-8 mr-2" src="./svgs/mortarboard.svg" alt="logo">
        <span class="text-white">LearnPlus</span>  
      </a>
      <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
          <h2 class="mb-1 text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
              Password change
          </h2>
          <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST">
              <div>
                  <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                  <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
              </div>
              <div>
                  <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password</label>
                  <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              </div>
              <div>
                  <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                  <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              </div>
              <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Reset password</button>
          </form>
      </div>
  </div>
</section>
<?php include 'footer.php';?>