<?php 
    include('partials/menu.php');
    include('../config/database.php');
    include('../config/constants.php');
?>


<div class="main-content">
    <div class="wrapper">
        <h1 style="text-align:center;">ADD CUSTOMER</h1>

        <br /><br>

                <?php
                    if(isset($_SESSION['add'])) //Checking whether the Session is Set of Not
                    {
                        echo $_SESSION['add']; //Display the Session Message if Set
                        unset($_SESSION['add']); //Remove Session Message
                    }  
                ?>
                <br />


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" placeholder="Enter Email"></td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter Username"></td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td><input type="text" name="password" placeholder="Enter Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Customer" class="btn-secondary" style="padding:20px">
                    </td>
                </tr>

            </table>
        </form>

    </div>  
</div>

<?php include('partials/footer.php'); ?>

<?php
    // Process the value from Form and save it in Database

    // Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked
        //echo "Button Clicked";

        //1. Get the Data from Form
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password']; // Password Encryption with MD5

        // SQL Query to Save the data into database
        $sql = "INSERT INTO tbl_customer SET
            email='$email',
            username='$username',
            password='$password'
            ";
        
        
        //3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'>Customer Added Successfully.</div>";
            //Redirect Page to Manage Customer
            header("location:".SITEURL.'admin/manage-customer.php');
        }
        else
        {
            //Failed to Insert Data
            //echo "Failed to Insert Data";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='error'>Failed to Add Customer.</div>";
            //Redirect Page to Add Customer
            header("location:".SITEURL.'admin/add-customer.php');
        }
    }
    else
    {
        // Button Not Clicked
        //echo "Button Not Clicked";
    }