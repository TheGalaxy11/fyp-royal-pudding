<form method="POST" action="get_pdf_id.php" target="_blank">
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
</form>

<?php include('partials-front/menu.php'); ?>

    <?php 
        //CHeck whether food id is set or not
        if(isset($_GET['food_id']))
        {
            //Get the Food id and details of the selected food
            $food_id = $_GET['food_id'];

            //Get the DEtails of the SElected Food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            //Execute the Query
            $res = mysqli_query($conn, $sql);
            //Count the rows
            $count = mysqli_num_rows($res);
            //CHeck whether the data is available or not
            if($count==1)
            {
                //WE Have DAta
                //GEt the Data from Database
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                //Food not Availabe
                //REdirect to Home Page
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirect to homepage
            header('location:'.SITEURL);
        }

        //CHeck whether submit button is clicked or not
        if(isset($_POST['submit']))
        {
            // Get all the details from the form

            $food = $_POST['food'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            $total = $price * $quantity; // total = price x quantity

            $order_date = date("Y-m-d h:i:sa"); //Order DAte

            $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled

            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];


            //Save the Order in Databaase
            //Create SQL to save the data
            $sql2 = "INSERT INTO tbl_order SET 
                food = '$food',
                price = $price,
                quantity = $quantity,
                total = $total,
                order_date = '$order_date',
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$customer_address'
            ";

            //echo $sql2; die();

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Check whether query executed successfully or not
            if($res2==true)
            {
                //Query Executed and Order Saved
                $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                header('location:'.SITEURL);
            }
            else
            {
                //Failed to Save Order
                $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
                header('location:'.SITEURL);
            }
        }
    
    ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-order">
  <div class="container">
      
      <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

      <form action="" method="POST" class="order">
          <fieldset>
              <legend style="color:#FFFFFF;">Selected Food</legend>

              <div class="food-menu-img">
                  <?php 
                  
                      //CHeck whether the image is available or not
                      if($image_name=="")
                      {
                          //Image not Availabe
                          echo "<div class='error'>Image not Available.</div>";
                      }
                      else
                      {
                          //Image is Available
                          ?>
                          <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                          <?php
                      }
                  
                  ?>
                  
              </div>

              <div class="food-menu-desc">
                  <h3 style="color:#FFFFFF;"><?php echo $title; ?></h3>
                  <input type="hidden" name="food" value="<?php echo $title; ?>">

                  <p class="food-price" style="color:#FFFFFF;">RM<?php echo $price; ?></p>
                  <input type="hidden" name="price" value="<?php echo $price; ?>">

                  <div class="order-label">Quantity</div>
                  <input type="number" name="quantity" class="input-responsive" value="1" required>
                  
              </div>

          </fieldset>
          
          <fieldset>
              <legend style="color:#FFFFFF;">Delivery Details</legend>
              <div class="order-label">Full Name</div>
              <input type="text" name="full-name" placeholder="E.g. Ahmad Danial" class="input-responsive" required>

              <div class="order-label">Phone Number</div>
              <input type="tel" name="contact" placeholder="E.g. 016-xxxxxxx" class="input-responsive" required>

              <div class="order-label">Email</div>
              <input type="email" name="email" placeholder="E.g. user@example.com" class="input-responsive" required>

              <div class="order-label">Address</div>
              <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

              <div style="text-align:center;">
              <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary" >
                </div>
          </fieldset>

      </form>
          

  </div>
</section>
<!---- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>