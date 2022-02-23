<?php

session_start();
require '../vendor/autoload.php';
use \Ovh\Api;

    // Setup the API
    $applicationKey = "PdVgdWqQLmxxVqHq";
    $applicationSecret = "nDQXB2tYVSNtCIJtljqNu8U8jQqfJXjG";
    $endpoint = "ovh-eu";
    $consumer_key = "lDISvBfSDDvhPyrD30G10Zrd8BPj9mDV";

    $ovh = new Api( $applicationKey,
        $applicationSecret,
        $endpoint,
        $consumer_key
    );

if(!isset($_SESSION['cartId'])) {

    //Creating cart

    echo "Creating cart...";

    $cart = $ovh->post('/order/cart', [
        "description" => "",
        "expriration" => "2022-02-23T15:00:00+00:00", // REMOVE THIS LINE FOR PRODUCTION
        "ovhSubsidiary" => "FR"
    ]);

    $_SESSION['cartId'] = $cart['cartId'];

    echo "\nCart number : $cartId";

    echo "\nCréation du pannier et de l'instance OVH\n";
    echo $_SESSION['cartId'];
}

// Initialize variables
$cartId = $_SESSION['cartId'];

if(isset($_POST['user'])) {

    $user = json_decode($_POST['user'], true);
    echo $user;

} elseif(isset($_POST['domain'])) {

    $domain = $_POST['domain'];
    echo $domain;

}

if(isset($_POST['action'])) {

    switch ($_POST['action']) {
        case "addDomain":
            echo "\naddDomain function";
            addDomain($domain);
            break;
        case "removeDomain":
            echo "\nremoveDomain function";
            removeDomain($domain);
            break;
        case "contact":
            echo "\nCreate contact function";
            createContact($user);
            break;
        case "validation":
            echo "\nValidation function";
            validation();
            break;
        default:
            echo "ERROR -> Aucune action selectionner";
    }

}


function addDomain($domain) {
    global $ovh, $cartId;

    // Domain orderable

    echo ("\nTest if domain is available");

    $unavailableDomain = false;

    echo("\nDomaine : $domain");

    //Request

    $url = "/order/cart/".$cartId."/domain?domain=".$domain;
    $dom = $ovh->get($url);

    //Condition if not orderable

    if($dom[0]['orderable'] == 0 || str_contains($dom[0]['offerId'], "transfer")) {

        echo (" unavailable");

        //Add domain to unvailable
        $unavailableDomain = true;

    } elseif($dom[0]['orderable'] == 1 || str_contains($dom[0]['offerId'], "create")) {

        echo(" available");

        //Add domain to the cart
        $addDomain = $ovh->post("/order/cart/".$cartId."/domain", [
            "domain"=>$domain
        ]);

    }


    echo("\n");

    // If domain is not available
    if($unavailableDomain == true) {

        print_r($unavailableDomain);
        echo "ERROR > 1";
        die();

    } else {

        print_r($domain);

    }



    // Refreshing Cart
    $cart = $ovh->get("/order/cart/".$cartId);
    print_r($cart);
    echo "ERROR > 0";

}


// Create owner Contact

//echo("\nCreating contact");
//
//$contact = $ovh->post("/me/contact", $user);
//
//echo($contact["id"]);




// Assign contact to each cart item (domain)

//foreach($cart['items'] as $item) {
//    echo "\nAssign owner contact to cart item $item";
//    $domain = $ovh->post("/order/cart/" . $cartId . '/item/' . $item . '/configuration', [
//        "label" => "OWNER_CONTACT",
//        "value" => '/me/contact/' . $contact['id']
//    ]);
//}



// Bind a cart to your account
//echo "\nBind cart to account";
//$ovh->post("/order/cart/".$cartId."/assign");
//
//// Let's checkout
//echo "\nCheckout";
//$salesorder = $ovh->post("/order/cart/".$cartId."/checkout");
//var_dump($salesorder);
