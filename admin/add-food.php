<?php
// Include necessary files and establish a database connection
include('partials/menu.php');
include('../config/database.php');
include('../config/constants.php');

// Check whether the form is submitted
if(isset($_POST['submit'])) {
    // Get the Data from Form and sanitize "title" and "description" fields
    $title = htmlspecialchars($_POST['title']); // Sanitize and allow symbols
    $description = htmlspecialchars($_POST['description']); // Sanitize and allow symbols
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Check whether radio buttons for "featured" and "active" are checked or not
    $featured = (isset($_POST['featured']) && $_POST['featured'] == 'Yes') ? 'Yes' : 'No';
    $active = (isset($_POST['active']) && $_POST['active'] == 'Yes') ? 'Yes' : 'No';

    // Upload the Image if selected
    if(isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        if ($image_name != "") {
            // Rename the Image
            $image_extension_parts = explode('.', $image_name);
            $ext = end($image_extension_parts);
            $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;
            $src = $_FILES['image']['tmp_name'];
            $dst = "../images/food/" . $image_name;
            $upload = move_uploaded_file($src, $dst);
            if ($upload == false) {
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                header('location:' . SITEURL . 'admin/add-food.php');
                die();
            }
        }
    } else {
        $image_name = "";
    }

    // Insert into Database using prepared statements
    $sql2 = "INSERT INTO tbl_food (title, description, price, image_name, category_id, featured, active)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql2);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssdssss", $title, $description, $price, $image_name, $category, $featured, $active);
        $res2 = mysqli_stmt_execute($stmt);
    }

    if($res2 == true) {
        $_SESSION['add'] = "<div class='success' style='text-align: center;'>Food Added Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['add'] = "<div class='error' style='text-align: center;'>Failed to Add Food.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
}
?>


<div class="main-content">
    <div class="wrapper">
        <h1 style="text-align:center;">ADD FOOD</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        
            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 
                                //Create PHP Code to display categories from Database
                                //1. CReate SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                
                                //Executing qUery
                                $res = mysqli_query($conn, $sql);

                                //Count Rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //IF count is greater than zero, we have categories else we donot have categories
                                if($count>0)
                                {
                                    //WE have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //WE do not have category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                            

                                //2. Display on Drpopdown
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes 
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes 
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary" style="padding:20px">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>