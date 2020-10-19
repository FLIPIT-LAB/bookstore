<?php

//check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){
	//get token, card and user info from the form
	$token  = $_POST['stripeToken'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$card_num = $_POST['card_num'];
	$card_cvc = $_POST['cvc'];
	$card_exp_month = $_POST['exp_month'];
	$card_exp_year = $_POST['exp_year'];
	
	//include Stripe PHP library
	require_once('stripe-php/init.php');
	
	//set api key
	$stripe = array(
	  "secret_key"      => "sk_test_5UEPEpYK96u2gWZhE4r19OqS00QSc21c3x",
	  "publishable_key" => "pk_test_TJZn6rQRIUq6yfMZ79YuZFd9"
	);
	
	\Stripe\Stripe::setApiKey($stripe['secret_key']);
	
	//add customer to stripe
	$customer = \Stripe\Customer::create(array(
		'email' => $email,
		'source'  => $token
	));
	
	//item information
	$itemName = "Premium Script Semicolan";
	$itemNumber = "PS123456";
	$itemPrice = 550;
	$currency = "usd";
	$orderID = "SKA92712382139";
	
	//charge a credit or a debit card
	$charge = \Stripe\Charge::create(array(
		'customer' => $customer->id,
		'amount'   => $itemPrice,
		'currency' => $currency,
		'description' => $itemName,
		'metadata' => array(
			'order_id' => $orderID
		)
	));
	
	//retrieve charge details
	$chargeJson = $charge->jsonSerialize();

	//check whether the charge is successful
	if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
		//order details 
		$amount = $chargeJson['amount'];
		$balance_transaction = $chargeJson['balance_transaction'];
		$currency = $chargeJson['currency'];
		$status = $chargeJson['status'];
		$date = date("Y-m-d H:i:s");
		
		//include database config file
		$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'bookstore';

//Connect with the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//Display error if failed to connect
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}
		
		//insert tansaction data into the database
		$sql = "INSERT INTO orders(name,email,card_num,card_cvc,card_exp_month,card_exp_year,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES('".$name."','".$email."','".$card_num."','".$card_cvc."','".$card_exp_month."','".$card_exp_year."','".$itemName."','".$itemNumber."','".$itemPrice."','".$currency."','".$amount."','".$currency."','".$balance_transaction."','".$status."','".$date."','".$date."')";
        $insert = $db->query($sql);
        $last_insert_id = $db->insert_id;
		
		//if order inserted successfully
		if($last_insert_id && $status == 'succeeded'){
			$statusMsg = "<script>
	alert('charged successfully. Your Order ID is : {$last_insert_id}. ')
	window.top.location='./profile.php'
	</script>";
		}else{
			$statusMsg = "Transaction has been failed";
		}
	}else{
		//print '<pre>';print_r($chargeJson);
		$statusMsg = "Transaction has been failed";
	}
}else{
	$statusMsg = "Form submission error.......";
}

//show success or error message
echo $statusMsg;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Payment Forms</title>
	<style>
	.formular {
  margin: auto;
  width: 50%;
  border: 1px solid #ddd;
  background-color: #fff;
  border-radius: 4px 4px 0 0;
  padding: 20px;
}

.bg-danger {
  margin: -20px;
}
.bg-danger p {
  padding: 20px;
}

.bg-info {
  padding: 10px;
  text-align: center;
}

.center {
  text-align: center;
}

fieldset {
  clear: both;
  border-bottom: 1px solid lightgrey;
  margin: 20px -20px;
  padding: 20px 0;
}

.center {
  text-align: center;
}

small {
  font-size: 0.8em;
}

	</style>
	
	<!-- Stripe JavaScript library -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
	
	<!-- jQuery is used only for this example; it isn't required to use Stripe -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	<script type="text/javascript">
		//set your publishable key
		Stripe.setPublishableKey('pk_test_TJZn6rQRIUq6yfMZ79YuZFd9');
		
		//callback to handle the response from stripe
		function stripeResponseHandler(status, response) {
			if (response.error) {
				//enable the submit button
				$('#payBtn').removeAttr("disabled");
				//display the errors on the form
				$(".payment-errors").html(response.error.message);
			} else {
				var form$ = $("#paymentFrm");
				//get token id
				var token = response['id'];
				//insert the token into the form
				form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
				//submit form to the server
				form$.get(0).submit();
			}
		}
		$(document).ready(function() {
			//on form submit
			$("#paymentFrm").submit(function(event) {
				//disable the submit button to prevent repeated clicks
				$('#payBtn').attr("disabled", "disabled");
				
				//create single-use token to charge the user
				Stripe.createToken({
					number: $('.card-number').val(),
					cvc: $('.card-cvc').val(),
					exp_month: $('.card-expiry-month').val(),
					exp_year: $('.card-expiry-year').val()
				}, stripeResponseHandler);
				
				//submit from callback
				return false;
			});
		});
	</script>
</head>
<body>
<div class="container" style="margin-left:auto">
<!-- display errors returned by createToken -->
<span class="payment-errors"></span>

<form action="" method="POST" id="paymentFrm">
<div class="formular" >
  <h3>Credit Card Payment Form</h3>
  <hr />

      <div class="form-group col-12">
        <label for="Firstname">First Name</label>
        <input type="text" size="50" name="name" id="Firstname" value="" class="form-control">
      </div>

      <div class="form-group col-12">
        <label for="E-Mail">E-Mail</label>
        <input type="text" size="50" name="email" id="E-Mail" value="" class="form-control">
      </div>

      <div class="form-group col-12">
        <label>
          <span>Credit Card Number</span>
        </label>
        <input type="text" size="20" name="card_num" class="form-control card-number" value="" />
      </div>

      <div class="form-group form-group col-4">
        <label>
          <span>CVC Code:</span>
        </label>
        <input type="text" size="4" name="cvc" class="form-control card-cvc" />
      </div>

      <div class="form-group col-4">
        <div class="col-12">
          <label>
            <span>Expiry<small> (MM/YY)</small>:</span>
          </label>
        </div>
        <div class="input-group">
          <input type="text" size="2" name="exp_month"  class="form-control card-expiry-month" placeholder="MM"/>
          <div class="input-group-addon">/</div>
          <input type="text" size="2" name="exp_year" class="form-control card-expiry-year" placeholder="YY"/>
        </div>
      </div>
    <div class="center">
      <button type="submit" class="col-12 btn btn-success" id="payBtn">Submit</button>
    </div>

  </form>
</div>
<div class="center">Test Card is: 4242424242424242</div>

</div>
</body>
</html>