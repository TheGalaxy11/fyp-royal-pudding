<?php

    // Include constants.php file here
    include('../config/constants.php');

    // 1. get the ID of Customer to be deleted
    $id = $_GET['id'];

    // 2. Create SQL Query to Delete Customer
    $sql = "DELETE FROM tbl_customer WHERE id=$id"; // Query to Delete Customer
    
    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully or not
    if($res==true)
    {
        // Query Executed Successfully and Customer Deleted
        $_SESSION['delete'] = '<div class="success" style="text-align: center;">Customer Deleted Successfully.</div>';
        // Redirect to Manage Customer
        header('location:'.SITEURL.'admin/manage-customer.php');
    }
    else
    {
        // Failed to Delete Customer
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Customer.</div>";
        // Redirect to Manage Customer
        header('location:'.SITEURL.'admin/manage-customer.php');
    }

    // 3. Redirect to Manage Customer page with message (success/error)

    ?>
