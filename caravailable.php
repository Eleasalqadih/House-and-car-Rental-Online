<?php
 include 'inc/header.php';
 include 'inc/navbar.php';
 include_once 'Controller/carcontroller.php';
?>

<div class="available_page_area">

<?php
 $home = new carcontroller();
 $data = $home->getCarDetails(); // تعديل الدالة للحصول على تفاصيل السيارات بدلاً من المنازل
 if(!$data){
   echo "<p>No data found</p>";
 }
?>

<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_car'])) {
    $arr = explode('-',$_POST['rental_value']);
    $range1 = substr($arr[0],1);
    $range2 = substr($arr[1],2);

    $data = $home->searchCar($range1, $range2, $_POST); // تعديل الدالة للبحث عن السيارات
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_cover'])) {
    $arr = explode('-',$_GET['rental_value']);
    $range1 = substr($arr[0],1);
    $range2 = substr($arr[1],2);

    $data = $home->searchCar($range1, $range2, $_GET); // تعديل الدالة للبحث عن السيارات
  }
?>

 <div class="available_page_main container">

   <div class="search_house">
     <div class="search_house_inner card">
       <div class="well search_card card-body">
         <form class="search_house_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
           <input type="text" name="car_type" class="form-control" value="<?php if(isset($_POST['car_type'])){
             echo $_POST['car_type'];
           } ?>" placeholder="Car Type">
           <select class="form-control" style="background-color:lavender;" name="rental_type">
             <option value="" selected disabled>Rent Type</option>
             <option value="Daily"
             <?php if(isset($_POST['rental_type']) && $_POST['rental_type']=='Daily'){
               echo "selected";
             } ?>
             >Daily</option>
             <option value="Monthly"
             <?php if(isset($_POST['rental_type']) && $_POST['rental_type']=='Monthly'){
               echo "selected";
             } ?>
             >Monthly</option>
           </select>
           <div id="range">
             <label for="input_range">Price range:</label>
             <input type="text" id="input_range" name="rental_value" readonly style="border:0; color:#f6931f; font-weight:bold;">
             <div id="main_range" class="myrange" title="Tap left or right button to set more precise value."></div>
           </div>

           <input type="submit" name="search_car" class="btn btn-info" value="Search Car">
         </form>
       </div>
     </div>
   </div>

   <div class="all_cars row">

<?php
 foreach ($data as $value) {
?>
     <div class="single_car card">
       <div class="single_car_inner card-body">
         <div class="car_title">
           <p style="font-weight:600;">  <i class="fas fa-car"></i> <?php echo $value['car_type']; ?> </p>
           <p class="rent"> <i class="fas fa-money-check-alt"></i> <?php echo $value['rental_type']; ?> </p>
         </div>
         <div class="car_img">
           <img src="assets/images/car/cae_icon.png" alt="Car"> <!-- تغيير الصورة حسب السيارة -->
         </div>
         <a href="cardetails.php?car_id=<?php echo $value['id']; ?>">Details</a>
       </div>
     </div>

<?php } ?>

   </div>
 </div>
</div>

<?php
 include 'inc/footer.php';
?>

<script>
$(function(){
  $( "#main_range" ).slider({
        range: true,
        min: 100,
        max: 1000,
        values: [<?php if(isset($range1) && isset($range2)){
          echo $range1.','.$range2;}
          else{?> 100,1000 <?php } ?>],
        slide: function( event, ui ) {
          $( "#input_range" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
   });
   $( "#input_range" ).val( "$" + $( "#main_range" ).slider( "values", 0 ) +
    " - $" + $( "#main_range" ).slider( "values", 1 ) );
  });
</script>