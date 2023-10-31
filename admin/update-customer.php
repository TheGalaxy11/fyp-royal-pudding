<?php 
    include('partials/menu.php');
    include('../config/database.php');
    include('../config/constants.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1 style="text-align:center;">UPDATE CUSTOMER</h1>

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
                        <td>Email:</td>
                        <td><input type="text" name="email" value="<?php echo $email; ?>"></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                    </tr>
    
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Customer" class="btn-secondary" style="padding:2%;">
                        </td>
                    </tr>
    
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
        $email=$_POST['email'];
        $username=$_POST['username'];

        //Create a SQL Query to Update Customer
        $sql="UPDATE tbl_customer SET
            email='$email',
            username='$username'
            WHERE id='$id'
        ";

        //Execute the Query
        $res=mysqli_query($conn, $sql);

        //Check whether the query executed successfully or not
        if($res==TRUE)
        {
            //Query Executed and Admin Updated
            $_SESSION['update']="<div class='success'>Customer Updated Successfully.</div>";
            //Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/manage-customer.php');
        }
        else
        {
            //Failed to Update Admin
            $_SESSION['update']="<div class='error'>Failed to Update Customer.</div>";
            //Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/manage-customer.php');
        }
    }
?>
            

    <?php include('partials/footer.php'); ?>