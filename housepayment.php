<?php
  include 'inc/header.php';
  include 'inc/navbar.php';
  Session::checkSession();
  if(Session::get('user') !== 'tenant'){
    Header('Location:index.php');
  }
?>
<style>
body {
font-family: Arial, sans-serif;
display: flex;
justify-content: center;
align-items: center;
height: 100vh;
margin: 0;
background-color: #f4f4f4;
text-align:center;
}
.payment-container {
width: 400px;
padding: 20px;
background-color: #fff;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
text-align: center;
border-radius: 8px;
text-align:center;
}
.payment-header {
font-size: 1.5em;
margin-bottom: 20px;
font-weight: bold;
text-align:center;
}
.bank-images {
display: flex;
justify-content: space-around;
margin-bottom: 20px;

}
.bank-images img {
width: 60px;
height: 40px;
cursor: pointer;
}
.form-group {
margin-bottom: 15px;
text-align: center;
}
label {
text-align: center;
display: block;
margin-bottom: 5px;
font-weight: bold;
}
input[type="text"], input[type="password"] {
width: 100%;
padding: 8px;
border: 1px solid #ccc;
border-radius: 4px;
text-align: center;
}
.submit-btn {
width: 100%;
padding: 10px;
background-color: #28a745;
color: #fff;
border: none;
border-radius: 4px;
font-size: 1em;
cursor: pointer;
text-align: center;
}
.submit-btn:hover {
background-color: #218838;
text-align: center;
}
</style>
<div class="payment-container"style="text-align:center;margin-top:15px;height:430px;width:450px">
<div class="payment-header" style="color:red">Payment Information</div>
<div class="bank-images">
<img src="assets/images/pay/alahli.jpeg">
<img src="assets/images/pay/alarabi.png">
<img src="assets/images/pay/alrajihi.png">
<img src="assets/images/pay/paypal.png">
<img src="assets/images/pay/visacard.jpeg">
</div>
<form  formaaction="availablehouse.php" method="post" style="text-align:center">
<div class="car_type form-group" style="margin-bottom:15px;">
<select class="form-control" name="car_type" required>
<option value="" selected disabled style="font-weight:bold">Select Bank Name</option>
<option value="Toyota"> ALRAJIHI</option>
<option value="Hyundai">ALAHALI</option>
<option value="BMW">VISA CARD</option>
<option value="RAV4">Paypal</option>
<option value="Other">Alarabi</option> <!-- نوع إضافي -->
</select>
</div>
<div class="form-group"style="text-align:right">
<label for="cardNumber"style="text-align:left;margin-bottom:8px ;color">Card Number:</label>
<input type="text" id="card_number" name="Card Number" required>
</div>
<div class="form-group"style="text-align:right">
<label for="password" style="text-align:left;margin-bottom:8px ;color">Password:</label>
 <input type="password" id="password" name="password" required>
</div>
<button type="submit" class="submit-btn" formaction="availablehouse.php">Submit</button>
</form>
</div>
    </div>
    </div>
    </div>
