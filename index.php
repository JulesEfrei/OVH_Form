<?php

require __DIR__ . '/vendor/autoload.php';
use \Ovh\Api;



// Setup the API
$applicationKey = "amH0epug2GXOG4VR";
$applicationSecret = "VxJiAp0eHbOrA6kyUWF01eXvsepLJGxA";
$endpoint = "ovh-eu";
$consumer_key = "iLL3MhlxOYgbR8ywvWgaIFpbtN53Pfak";


$ovh = new Api( $applicationKey,
    $applicationSecret,
    $endpoint,
    $consumer_key
);



// Initialize variables
$user = json_decode($_POST['user'], true);
$domain = $_POST['domain'];

// Convert string to array
$domain = str_replace("[", "", $domain);
$domain = str_replace('"', "", $domain);
$domain = str_replace("]", "", $domain);
$domain = explode(",", $domain);

print_r($domain);

print_r($user);



// Creating Cart

echo("\nCreating cart");

$cart = $ovh->post('/order/cart', [
    "description" => "",
    "expriration" => "2022-02-04T15:00:00+00:00", //REMOVE THIS LINE FOR PRODUCTION
    "ovhSubsidiary" => "FR"
]);

$cartId = $cart['cartId'];

echo ("\nCart number : $cartId");



// Domain orderable

echo ("\nTest if domain is available");

$unavailableDomain = [];

foreach ($domain as $elm) {

    echo("\nDomaine : $elm");

    //Request
    $url = "/order/cart/".$cartId."/domain?domain=".$elm;
    $dom = $ovh->get($url);

    //Condition if not orderable
    if($dom[0]['orderable'] == 0 || str_contains($dom[0]['offerId'], "transfer")) {

        echo (" unavailable");

        //Add domain to unvailable
        array_push($unavailableDomain, $elm);
        //Remove domain to global array
        $key = array_search($elm, $domain);
        unset($domain[$key]);

    } elseif($dom[0]['orderable'] == 1 || str_contains($dom[0]['offerId'], "create")) {

        echo(" available");
        //Add domain to the cart
        $addDomain = $ovh->post("/order/cart/".$cartId."/domain", [
            "domain"=>$elm
        ]);

    }

}



echo("\n");
if(!empty($unavailableDomain)) {
    print_r($unavailableDomain);
    echo("Error >");
    die();
} else {
    print_r($domain);
}



// Refreshing Cart
$cart = $ovh->get("/order/cart/".$cartId);
print_r($cart);



// Create owner Contact

echo("\nCreating contact");

$contact = $ovh->post("/me/contact", $user);

echo($contact["id"]);




// Assign contact to each cart item (domain)

foreach($cart['items'] as $item) {
    echo "\nAssign owner contact to cart item $item";
    $domain = $ovh->post("/order/cart/" . $cartId . '/item/' . $item . '/configuration', [
        "label" => "OWNER_CONTACT",
        "value" => '/me/contact/' . $contact['id']
    ]);
}



// Bind a cart to your account
echo "\nBind cart to account";
$ovh->post("/order/cart/".$cartId."/assign");

// Let's checkout
echo "\nCheckout";
$salesorder = $ovh->post("/order/cart/".$cartId."/checkout");
var_dump($salesorder);
