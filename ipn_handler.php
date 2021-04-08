<?php
if (!in_array($_SERVER['REMOTE_ADDR'], array('162.0.238.125'))) return;

if (isset($_POST['operation_id']) && isset($_POST['verify_sign']))
{
	$secret_key = ''; // YOUR SCI SECRET KEY

	$arHash = array(
		$_POST['operation_id'], // Return Payment Transaction ID
		$_POST['operation_pm'], // Return Payment Method 
		$_POST['operation_date'], // Return Date
		$_POST['operation_pay_date'], // Return Date when payment was made
		$_POST['merchant_id'], // Return API ID
		$_POST['item_number'], // Return Order number
		$_POST['item_price'], // Return Item Amount
		$_POST['item_currency'], // Return Item Currency
		$_POST['item_name'], // Return Item Name
		$_POST['operation_status'] // Return Payment Status
	);

	if (isset($_POST['params']))
	{
		$arHash[] = $_POST['params'];
	}

	$arHash[] = $secret_key;
	$input_params = implode(" : ",$arHash);

	$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

	if ($_POST['verify_sign'] == $sign_hash && $_POST['operation_status'] == 'success')
	{
		ob_end_clean(); 
        // PAYMENT WAS SUCCESSFULLY
        // YOU CAN PROCESS YOUR ORDER
		file_put_contents("payhistory.txt",$input_params.' |ipn success');
		exit($_POST['item_number'].'|success');
	}

	ob_end_clean(); 
	// PAYMENT WAS FAILED
	file_put_contents("payhistory.txt",$input_params.' |ipn fail');
	exit($_POST['item_number'].'|error');
}
?>