<?php 
include('partials/menu.php');
include('../config/database.php');
include('../config/constants.php');
?>


<!-- Menu Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
    <h1 style="text-align:center;">
            MANAGE CUSTOMER
            <a href="<?php echo SITEURL; ?>admin/add-customer.php" class="btn-add" style="margin-left: 20px;">
                <i class="fa-solid fa-plus"></i>
            </a>
        </h1>
        <br /><br />
        
        <?php
                    if(isset($_SESSION['add'])) //Checking whether the Session is Set of Not
                    {
                        echo $_SESSION['add']; //Display the Session Message if Set
                        unset($_SESSION['add']); //Remove Session Message
                    }  

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }
                ?>
        
        <br /><br />
        
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Email</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            <?php
                //Query to Get all Customer
                $sql = "SELECT * FROM tbl_customer";
                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Check whether the Query is Executed of Not
                if($res==TRUE)
                {

                    // Count Rows to check whether we have data in database or not
                    $count = mysqli_num_rows($res); // Function to get all the rows in database

                    $sn=1; //Create a Variable and Assign the value

                    //Check the num of rows
                    if($count>0)
                    {
                        //We have data in database
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            //Using While loop to get all the data from database.
                            //And while loop will run as long as we have data in database

                            //Get individual data
                            $id=$rows['id'];
                            $email=$rows['email'];
                            $username=$rows['username'];

                            //Display the Values in our Table
                            ?>
                            
                            <tr>
                                <td><?php echo $sn++; ?>. </td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $username; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary" style="padding:6%"><i class="fa-solid fa-key"></i></a>
                                    <a href="<?php echo SITEURL; ?>admin/update-customer.php?id=<?php echo $id; ?>" class="btn-secondary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-customer.php?id=<?php echo $id; ?>" class="btn-delete"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>

                            <?php
                        }
                    }
                    else
                    {
                        //We do not have data in database
                    }
                }
            ?>
        </table>
    </div>
</div>
<!-- Menu Content Section Ends -->

<?php include('partials/footer.php'); ?>