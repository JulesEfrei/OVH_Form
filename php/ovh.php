<?php
require 'vendor/autoload.php';

$account =     [
    "id" => "OC3568-OVH",
    "pass" => "",
    "application_key" => "YYEiOtjR",
    "application_secret" => "DIUaxDepEGPiCfqyQ8YIuQwj",
    "consumer_key" => "lxB94oPU7QZP",
];

$domains = [
	"aproconseilformation.com",
];
$ownerContact = [
	'legalForm' => 'individual', // administration, association, corporation, individual, other, personalcorporation
	'gender' => 'male', // female, male
	'firstName' => 'Joël',
	'lastName' => 'Alexandre',
	'language' => 'fr_FR',
	//'organisationType' => 'SARL',
	//'organisationName' => 'pÔdane-maison responsable',
    'address' => [
		'country' => 'GP',
		'line1' => 'Route de Lamarre',
		'line2' => '',
		'zip' => '97180',
		'city' => 'Sainte-Anne',
	],
	//'birthDay' => '1966-09-06',
	'email' => 'aproconseil@yahoo.fr',
	'phone' => '0690830274',
];


use \Ovh\Api;

$endpoint = 'ovh-eu';
$rights = array( (object) [
    'method'    => 'GET',
    'path'      => '/me*'
]);

$ovh = new Api($account['application_key'], $account['application_secret'], $endpoint, $account['consumer_key']);


// Create a cart
echo "\nCreating a cart";
$cart = $ovh->post('/order/cart', [
    'description' => '',
    'ovhSubsidiary' => 'FR'
]);
echo " ".$cart['cartId'];


$domainUnorderable = false;
foreach($domains as $d){
	// Search for a product
	$domain = $ovh->get("/order/cart/".$cart['cartId']."/domain", [
		"domain" => $d
	]);

	if($domain[0]['orderable']){
		// Add an item
		echo "\nAdding $d to cart";
		$domain = $ovh->post("/order/cart/".$cart['cartId']."/domain", [
			"domain" => $d
		]);
	}else{
		echo "\nDomain $d unorderable";
		$domainUnorderable = true;
	}
}
if($domainUnorderable){
	exit;
}

echo "\nRefreshing cart";
$cart = $ovh->get("/order/cart/".$cart['cartId']);

// Create owner contact
echo "\nCreating owner contact";
$contact = $ovh->post('/me/contact', $ownerContact);
//$contact = $ovh->get("/me/contact/"."12173709");
echo " ".$contact['id'];

// Assign contact to each cart item (domain)
foreach($cart['items'] as $item){
	echo "\nAssign owner contact to cart item $item";
	$domain = $ovh->post("/order/cart/".$cart['cartId'].'/item/'.$item.'/configuration', [
		"label" => "OWNER_CONTACT",
		"value" => '/me/contact/'.$contact['id']
	]);
		
	/*$infos = $ovh->get('/order/cart/'.$cart['cartId'].'/item/'.$item.'');

	dump($cart);
	dump($infos);

	$config = $ovh->get('/order/cart/'.$cart['cartId'].'/item/'.$item.'/configuration/'.$infos['configurations'][0]);

	dump($config);

	$requiredConfig = $ovh->get('/order/cart/'.$cart['cartId'].'/item/'.$item.'/requiredConfiguration');

	dump($requiredConfig);*/
}

// Bind a cart to your account
echo "\nBind cart to account";
$ovh->post("/order/cart/".$cart['cartId']."/assign");

// Let's checkout
echo "\nCheckout";
$salesorder = $ovh->post("/order/cart/".$cart['cartId']."/checkout");
//dump($salesorder);

// Automatisation of payment procedure
//$availableRegisteredPaymentMean = $ovh->get("/me/order/".$salesorder['orderId']."/availableRegisteredPaymentMean");

//$paymentMeans = $ovh->get("/me/order/".$salesorder['orderId']."/paymentMeans");
$bankAccount = $ovh->get("/me/paymentMean/bankAccount");
//exit;
$order = $ovh->post("/me/order/".$salesorder['orderId']."/payWithRegisteredPaymentMean", [
    "paymentMean" => 'bankAccount',
    "paymentMeanId" => $bankAccount[0],
]);

//dump($order);