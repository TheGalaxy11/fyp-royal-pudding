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
    <title>Login - Royal Pudding D'JB</title>
 
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
                <header>Customer Login</header>
                
                <?php
                    if (isset($_POST["login"])) {
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        require_once "config/database.php";
                        $sql = "SELECT * FROM tbl_customer WHERE email = ?";
                        // Use prepared statements
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "s", $email); // Bind the email parameter
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        if ($user) {
                            if ($password === $user["password"]) {  // Compare passwords in plain text
                                session_start();
                                $_SESSION["user"] = "yes";
                                header("Location: index.php");
                                die();
                            } else {
                                echo '<div class="alert alert-danger" style="text-align: center;">Password does not match</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" style="text-align: center;">Email does not match</div>';
                        }
                    }
                ?>

                <form action="login.php" method="post">
                    <div class="field input-field">
                        <input type="text" placeholder="Email" class="input" name="email" required>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" name="password" required>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="form-link">
                    <span>login as <a href="admin/login.php" class="link signup-link">admin</a></span>
                    </div>

                    <div class="field button-field">
                        <button type="submit" value="Login" name="login">Login</button>
                    </div>
                </form>

                <div class="form-link">
                    <span>Don't have an account? <a href="signup.php" class="link signup-link">Signup</a></span>
                </div>
            </div>
        </div>

        <script>
            const forms = document.querySelector(".forms");
            const pwShowHide = document.querySelectorAll(".eye-icon");
            const links = document.querySelectorAll(".link");
    
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
            });
        </script>
    </section>
</body>
</html>
