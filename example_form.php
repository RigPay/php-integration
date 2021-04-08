<?php
$merchant_name = 'RIGPAY'; // Your SCI Name
$merchant_id = '123123'; // Your SCI Merchant ID
$secret_key = '123123123'; // Your SCI Secret Key
$encryption_key = 'd125b8a8443c05df210d8900398e957b'; // Your Encryption Key
$item_number = '1'; // Order ID
$item_name = 'Order Digital Products'; // Order Name
$item_price = '1000'; // Order Amount
$item_currency = 'USD'; // Order currency can be USD, EUR, BTC, ETH and etc...

$arHash = array(
	$merchant_name,
	$item_number,
	$item_price,
	$item_currency,
	$item_name,
	$secret_key
);

$key = md5($encryption_key.$item_number);

$params = @urlencode(base64_encode(openssl_encrypt(json_encode($arHash), 'AES-256-CBC', $key, OPENSSL_RAW_DATA)));

$sign = strtoupper(hash('sha256', implode(':', $arHash)));
?>
<form action="http://localhost/escrow/checkout/" method="POST">
	<input type="hidden" name="merchant_name" value="<?php echo $merchant_name; ?>">
	<input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
	<input type="hidden" name="item_number" value="<?php echo $item_number; ?>">
	<input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
	<input type="hidden" name="item_price" value="<?php echo $item_price; ?>">
	<input type="hidden" name="item_currency" value="<?php echo $item_currency; ?>">
	<input type="hidden" name="hash_verify" value="<?php echo $sign; ?>">
	<input type="hidden" name="params" value="<?php echo $params; ?>">
	<input type="hidden" name="return_ipn" value="http://yourwebsite.com/ipn_headler.php">
	<input type="hidden" name="return_success" value="http://yourwebsite.com/success_payment.php">
	<input type="hidden" name="return_fail" value="http://yourwebsite.com/failed_payment.php">
	<button type="submit">Pay via RigPay</button>
</form>