<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Signup - Royal Pudding D'JB</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Sign Up</header>

    <?php
        if (isset($_POST["submit"])) {
           $username = $_POST["username"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $errors = array();
           
           if (empty($username) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors, '<div class="alert alert-danger" style="text-align: center;">*All fields are required</div>');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, '<div class="alert alert-danger" style="text-align: center;">*Email is not valid</div>');
        }
        if (strlen($password) < 8) {
            array_push($errors, '<div class="alert alert-danger" style="text-align: center;">**Password must be at least 8 characters long</div>');
        }
        if ($password !== $passwordRepeat) {
            array_push($errors, '<div class="alert alert-danger" style="text-align: center;">*Password does not match</div>');
        }

        require_once "config/database.php";
        $sql = "SELECT * FROM tbl_customer WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            array_push($errors, '<div class="alert alert-danger" style="text-align: center;">*Email already exists!</div>');
        }
           if (count($errors) > 0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           } else {
            
            $sql = "INSERT INTO tbl_customer (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
                mysqli_stmt_execute($stmt);
                echo '<div class="alert alert-success" style="text-align: center;">You are registered successfully</div>';
            } else {
                die("Something went wrong");
            }
           }
        }
    ?>

            
                <form action="signup.php" method="post">

                    <div class="field input-field">
                        <input type="text" placeholder="Username" class="input" name="username" autocomplete="off" required>
                    </div>

                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email" autocomplete="off" required>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" name="password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Confirm password" class="password" name="repeat_password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field button-field">
                        <button type="submit" value="Submit" name="submit">Signup</button>
                    </div>
                </form>

                <div class="form-link">
                    <span>Already have an account? <a href="login.php" class="link signup-link">Login</a></span>
                </div>
            </div>

            <!--- <div class="line"></div>

            <div class="media-options">
                <a href="#" class="field facebook">
                    <i class='bx bxl-facebook facebook-icon'></i>
                    <span>Login with Facebook</span>
                </a>
            </div>

            <div class="media-options">
                <a href="#" class="field google">
                    <img src="images/google.png" alt="" class="google-img">
                    <span>Login with Google</span>
                </a>---->
        </div>

    <script>
        const forms = document.querySelector(".forms"),
        pwShowHide = document.querySelectorAll(".eye-icon"),
        links = document.querySelectorAll(".link");

        pwShowHide.forEach(eyeIcon => {
            eyeIcon.addEventListener("click", () => {
                let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");
                
                pwFields.forEach(password => {
                    if (password.type === "password") {
                        password.type = "text";
                        eyeIcon.classList.replace("bx-hide", "bx-show");
                        return;
                    }
                    password.type = "password";
                    eyeIcon.classList.replace("bx-show", "bx-hide");
                })
            })
        })   
    </script>
</body>
</html>
