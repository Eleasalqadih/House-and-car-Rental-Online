<?php
  include 'inc/header.php';
  include 'inc/navbar.php';
  include 'Controller/carcontroller.php';
  include 'Controller/Homecontroller.php';
 ?>
<div class="housedetails_area">
  <div class="housedetails_main container">
    <div class="housedetails_inner row">

<?php
  $carr = new carcontroller();
  if(isset($_GET['car_id'])){
    $id = $_GET['car_id'];
  }
  $car = $carr->getCarDetails_Obj($id);
  $carid = $car['id'];

  $ownerid = $car['owner_id'];
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['free_car'])){
    $req = $carr->freeCar($carid);
    echo "<meta http-equiv='refresh' content='0'>";
  }
 ?>

 <?php
   if(($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['delcar'])){
$car->deletecar($carid,Session::get('user_id'));
   }
  ?>

 
<div class="house_slider col-sm-6">
        <div class="house_slider_inner">
          <div class="all_house_slider" style="border:1px solid black; margin-right:20px;margin-left:5px:width:100px">
       <?php if($car['img_1'] != ''){?>
       <div class="single_house_slider">
         <img src="<?php echo $car['img_1']; ?>" alt="">
       </div>
       <?php } ?>
       <?php if($car['img_2'] != ''){?>
       <div class="single_house_slider">
         <img src="<?php echo $car['img_2']; ?>" alt="">
       </div>
       <?php } ?>
       <?php if($car['img_3'] != ''){?>
       <div class="single_house_slider">
         <img src="<?php echo $car['img_3']; ?>" alt="">
       </div>
       <?php } ?>
     </div>
   </div>
 </div>
      <div class="house_details col-sm-4" style="margin-top:20px; font-size:17px">
      <div class="house_details_inner">
     <table>
       <tr>
         <td> <strong>Type:</strong> </td>
         <td> <?php echo $car['car_type']; ?> </td>
       </tr>
    <tr>
      <td> <strong> Plate number:</strong> </td>
      <td><?php echo $car['plate_number']; ?></td>
    </tr>
       <tr>
         <td> <strong>Car Model:</strong> </td>
         <td> <?php echo $car['Car_model']; ?> </td>
       </tr>
    <tr>
      <td> <strong>Car Color: </strong> </td>
      <td><?php echo $car['car_color']; ?></td>
    </tr>
     <tr>
       <td> <strong>Car Number: </strong> </td>
       <td><?php echo $car['car_number']; ?></td>
     </tr>
         <tr>
           <td> <strong>Rental Type:</strong> </td>
           <td> <?php echo $car['rental_type']; ?> </td>
         </tr>
     </table>
   </div>
 </div>
 <div class="action_area col-sm-2">
   <div class="action_main">

   <?php
            $total_req = $carr->totalRequestcar($carid);

            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accept'])) {
              $tenants_id = $_POST['tenant_id'];
              $req = $carr->acceptrequest($carid,$tenants_id);
              echo "<meta http-equiv='refresh' content='0'>";
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reject'])) {
              $tenants_id = $_POST['tenant_id'];
              $req = $carr->rejectrequest($carid,$tenants_id);
              echo "<meta http-equiv='refresh' content='0'>";
            }
           ?>
     <?php if($car['owner_id'] == Session::get('user_id')){ ?>
     <div class="single_action">

       <?php
         if( $car['tenant_id'] != 0) {
           $tenant = $carr->getUser($car['tenant_id']);
        ?>
        <div class="dropdown">
           <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
             Booked by <a href="tenant_profile.php?tenant_id=<?php echo $tenant->id; ?>" target="_blank" ><?php echo $tenant->fname.' '.$tenant->lname; ?></a>
           </button>
           <div style="left:45px !important;" class="dropdown-menu">
             <form class="dropdown-item" action="<?php echo $_SERVER['PHP_SELF'].'?car_id='.$car['id'];?>" method="post">
               <input style="cursor:pointer;" type="submit" class="btn btn-default" name="free_car" value="Free">
             </form>
           </div>
         </div>
       <?php }else{?>
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
           Booked request<span style="margin-left:5px;" class="badge badge-light"><?php if(is_array($total_req)){echo count($total_req);} ?></span>
         </button>
       <?php } ?>



         <form action="<?php echo $_SERVER['PHP_SELF'].'?car_id='.$carid; ?>" method="post" style="margin-top:10px;">
           <input type="submit" class="btn btn-danger" onclick="return confirm('Are you Sure to Delete?');" name="delcar" value="Delete This Car">
         </form>

         <!-- The Modal -->
         <div style="top:200px;z-index:9999999999;" class="modal fade" id="myModal">
           <div class="modal-dialog modal-lg">
             <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                 <h4 class="modal-title">All requests for this car.</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                 <?php
                   if (count($total_req)>0) {
                     foreach ($total_req as $request) {
                       $tenant = $carr->getUser($request['tenant_id']);
                  ?>
                 <form class="" action="<?php echo $_SERVER['PHP_SELF'].'?car_id='.$car['id'];?>" method="post">
                   <div class="row">
                     <p style="padding-top:5px;" class="col-sm-6"> <a href="tenant_profile.php?tenant_id=<?php echo $tenant->id; ?>" target="_blank" > <?php echo $tenant->fname.' '.$tenant->lname; ?></a></p>
                     <input type="hidden" name="tenant_id" value="<?php echo $tenant->id; ?>">
                     <div class="accept_btn col-sm-2 ">
                       <input style="width:90%;" class="btn btn-success" type="submit" name="accept" value="Accept">
                     </div>
                     <div class="reject_btn col-sm-2">
                       <input style="width:90%;" class="btn btn-danger" type="submit" name="reject" value="Reject">
                     </div>
                   </div>
                 </form>
                 <?php
                   } }
                  ?>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
             </div>
           </div>
         </div>
     </div>
   <?php } ?>


<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request'])) {
    $req = $carr->sendrequest($carid,$ownerid);
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel'])) {
    $cancel = $carr->cancelrequest($carid,$ownerid);
  }
  $check = $carr->checkrequest($carid);
 ?>

<?php if(Session::get('user') == 'tenant'){ ?>
<div class="single_action">
  <form action="Paymentcar.php"  name="post" style="color:blue; width:50px;height:40px;margin-bottom:10px">
<input type="submit" value="pay for rent" style="background-color:blue; width:120px;height:40px;margin-bottom:10px">
</form>
 <form class="" action="<?php echo $_SERVER['PHP_SELF'].' ?car_id='.$car['id'];?>" 
method="post" id="rentForm">
 <?php
 if ($check=='no') {
 ?>
  <input type="submit" class="btn btn-primary"  name="request" value="Request for rent"> <?php } else if($check=='yes'){ ?>
 <input type="submit" class="btn btn-danger" name="cancel" value="Cancel Booked">
 <?php } else if($check=='booked'){ ?>
 <p class="btn btn-primary">Booked by You</p>
 <?php } ?>
 </form>
</div>
<div class="single_action">
       <a class="btn btn-info" href="owner_profile.php?owner_id=<?php echo $car['owner_id']; ?>">Contact the owner</a>
     </div>
<?php } else if(!Session::get('user') == 'owner'){ ?>
 
  <div class="single_action">
    <a class="btn btn-info" onclick="loginpage(<?php echo $car['id']; ?>);">Contact the owner</a>
  </div>
<?php } ?>
<script>
  function loginpage($id){
    <?php
   Session::set('path',"cardetails.php?car_id=".$id);
?>
window.location = "user_login.php";
  }
</script>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
  include 'inc/footer.php';
 ?>








<input type="submit" class="btn btn-primary" formaction="Paymentcar.php?car_id=<?php echo $car['id'];?>&owner_id=<?php echo $car['owner_id'];?>"  name="request" value="Request for rent">
