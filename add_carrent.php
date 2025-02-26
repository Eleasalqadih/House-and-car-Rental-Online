<?php
  include 'inc/header.php';
  include 'inc/navbar.php';
  include 'Controller/CarRent.php'; // استخدام Controller جديد خاص بالسيارات
  Session::checkSession();
  if(Session::get('user') !== 'owner'){
    Header('Location:index.php');
  }
?>
 <div class="housearea">
    <div class= "housemain container">
      <div class="inner_house">
        <div class="title_house">
          <h3>Give details Your Cars</h3>

    <?php
      $carcon = new CarRent(); // استدعاء كائن التحكم الخاص بالسيارات
      if(($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['add_car_rent']) ){
        $result = $carcon->addRent($_POST,$_FILES); // استدعاء دالة لإضافة سيارة
      }

      if((isset($result)) && ($result=='success')){
        echo "<p class='alert alert-success alert-dismissible'>New House rent added successfully!</p>";
        $result = null;
      }
      else if((isset($result)) && ($result=='fail')){
        echo "<p class='alert alert-danger alert-dismissible'>There are problem to add this house rent now!</p>";
        $result = null;
      }
      else if((isset($result)) && ($result=='fail')){
        echo "<p class='alert alert-danger alert-dismissible'>There was a problem adding this car rent!</p>";
        $result = null;
      }
    ?>

        </div>
        <div class="form_main">
          <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <!-- car type -->
            <div class="car_type form-group" style="margin-bottom:15px;">
              <select class="form-control" name="car_type" required>
                <option value="" selected disabled>Select Car Type</option>
                <option value="Toyota">Toyota</option>
                <option value="Hyundai">Hyundai</option>
                <option value="BMW">BMW</option>
                <option value="RAV4">RAV4</option>
                <option value="Other">Other</option> <!-- نوع إضافي -->
              </select>
            </div>

            <!-- rental type -->
            <div class="rental_type form-group" style="margin-bottom:15px;">
              <select class="form-control" name="rental_type" required>
                <option value="" selected disabled>Select Rental Type</option>
                <option value="daily">Daily - $35</option>
                <option value="monthly">Monthly - $1000</option>
              </select>
            </div>
            <div class="address">
      <input type="text" class="form-control" name="car_color" placeholder="Car Color">
    </div>
    <div class="address">
      <input type="text" class="form-control" name="car_number" placeholder="Car Number">
    </div>
    <div class="address">
      <input type="text" class="form-control" name="plate_number" placeholder="Licence Plate Number">
    </div>
    <div class="address">
      <input type="text" class="form-control" name="car_model" placeholder="Car Model">
    </div>
    
            <!-- image upload (optional) -->
            <div class="image_input">
              <p>Add image of your Car (Optional, Maximum 3)</p>
              <div class="inner_image_input">
                <div class="main_input">
                  <input type="file" class="form-control-file" name="img_1" placeholder="Add Image (Optional)">
                  <span class="plus_btn"> <i class="fas fa-plus"></i> </span>
                  <span class="minus"> <i class="fas fa-minus"></i> </span>
                </div>
              </div>
            </div>

            <p class="text-center" style="margin-top:10px;">
              <input type="submit" class="btn btn-info" name="add_car_rent" value="Add Car for Rent">
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php
  include 'inc/footer.php';
?>

