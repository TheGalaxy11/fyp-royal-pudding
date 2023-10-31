<?php 
    include('partials/menu.php');
    include('../config/database.php');
    include('../config/constants.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1 style="text-align:center;">CHANGE PASSWORD</h1>

        <br><br>

        <?php
            //1. Get the ID of selected customer
            $id=$_GET['id'];    

            //2. Create SQL Query to get the details
            $sql="SELECT * FROM tbl_customer WHERE id=$id";

            //3. Execute the Query
            $res=mysqli_query($conn, $sql);

            //Check whether the query is executed or not
            if($res==TRUE)
            {
                //Check whether the data is available or not
                $count=mysqli_num_rows($res);

                //Check whether we have customer data or not
                if($count==1)
                {
                    //Get the Details
                    //echo "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $email=$row['email'];
                    $username=$row['username'];
                }
                else
                {
                    //Redirect to Manage Admin Page
                    header('location:'.SITEURL.'admin/manage-customer.php');
                }
            }
        ?>
        <form action="" method="POST">
                
                <table class="tbl-30">
                    <tr>
                        <td>Current Password:</td>
                        <td><input type="password" name="current_password" placeholder="Old Password"></td>
                    </tr>
    
                    <tr>
                        <td>New Password:</td>
                        <td><input type="password" name="new_password" placeholder="New Password"></td>
                    </tr>

                    <tr>
                        <td>Confirm Password:</td>
                        <td><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary" style="padding:2%;">
                        </td>
                </table>
            </form>
    </div>
</div>

<?php
    //Check whether the submit button is clicked or not'
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        //Get all the values from form to update
        $id=$_POST['id'];
        $current_password=$_POST['current_password'];
        $new_password=$_POST['new_password'];
        $confirm_password=$_POST['confirm_password'];  

        //Create a SQL Query to Update Admin
        $sql="SELECT * FROM tbl_customer WHERE id=$id AND password='$current_password'"; 

        //Execute the Query
        $res=mysqli_query($conn, $sql);

        //Check whether the query executed successfully or not
        if($res==TRUE)
        {
            $count=mysqli_num_rows($res);

            if($count==1){
                //User exists and password can be changed
                //echo "User Found";

                //Check whether the new password and confirm match or no
                if($new_password==$confirm_password)
                {
                    //Update the Password
                    $sql2="UPDATE tbl_customer SET
                        password='$new_password'
                        WHERE id=$id
                    ";

                    //Execute the Query
                    $res2=mysqli_query($conn, $sql2);

                    //Check whether the query executed or not
                    if($res2==TRUE)
                    {
                        //Display Success Message
                        //Redirect to Manage Admin Page with Success Message
                        $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-customer.php');
                    }
                    else{
                        //Display Error Message
                        //Redirect to Manage Admin Page with Error Message
                        $_SESSION['change-pwd']="<div class='error'>Failed to Change Password.</div>";
                        header('location:'.SITEURL.'admin/manage-customer.php');
                    }
                }
                else{
                    //Redirect to Manage Admin Page with error message
                    $_SESSION['pwd-not-match']="<div class='error'>Password did not match.</div>";
                    header('location:'.SITEURL.'admin/manage-customer.php');
                }
            }
            else{
                //User does not exist and password cannot be changed
                $_SESSION['pwd-not-match']="<div class='error'>Password did not match.</div>";
                header('location:'.SITEURL.'admin/manage-customer.php');
            }
        }
    }
?>

    <?php include('partials/footer.php'); ?>