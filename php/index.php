<?php

session_start();
require '../vendor/autoload.php';
use \Ovh\Api;



// Setup the API

$applicationKey = "PdVgdWqQLmxxVqHq";
$applicationSecret = "nDQXB2tYVSNtCIJtljqNu8U8jQqfJXjG";
$endpoint = "ovh-eu";
$consumer_key = "lDISvBfSDDvhPyrD30G10Zrd8BPj9mDV";

$ovh = new Api( $applicationKey, $applicationSecret, $endpoint, $consumer_key);



//If cart doesn't exist
if(!isset($_SESSION['cartId'])) {

    //Creating cart

    $cart = $ovh->post('/order/cart', [
        "description" => "",
        "expriration" => "2022-02-23T15:00:00+00:00", // REMOVE THIS LINE FOR PRODUCTION
        "ovhSubsidiary" => "FR"
    ]);

    //Add cart to the session
    $_SESSION['cartId'] = $cart['cartId'];

}

// Initialize variables
$cartId = $_SESSION['cartId'];

if(isset($_POST['user'])) {

    $user = json_decode($_POST['user'], true);

} elseif(isset($_POST['domain'])) {

    $domain = $_POST['domain'];

}



//Function router
if(isset($_POST['action'])) {

    switch ($_POST['action']) {
        case "addDomain":
            addDomain($domain);
            break;
        case "removeDomain":
            removeDomain($domain);
            break;
        case "contact":
            createContact($user);
            break;
        case "validation":
            validation();
            break;
        case "updateDomain":
            updateDomain();
            break;
        case "getInfo":
            getInfo();
            break;
        default:
//            echo "ERROR -> Aucune action selectionner";
    }

}



//Ask if a domain is available
function addDomain($domain) {
    global $ovh, $cartId;

    $unavailableDomain = false;

    //Request

    $url = "/order/cart/".$cartId."/domain?domain=".$domain;
    $dom = $ovh->get($url);

    //Condition if not orderable

    if($dom[0]['orderable'] == 0 || str_contains($dom[0]['offerId'], "transfer")) {

        //Set domain to unvalaible
        $unavailableDomain = true;

    } elseif($dom[0]['orderable'] == 1 || str_contains($dom[0]['offerId'], "create")) {

        //Add domain to the cart
        $addDomain = $ovh->post("/order/cart/".$cartId."/domain", [
            "domain"=>$domain
        ]);

    }

    // If domain is not available
    if($unavailableDomain == true) {

        echo "Response Code > 1";
        die();

    }

    // Refreshing Cart
    $cart = $ovh->get("/order/cart/".$cartId);
    echo "Response Code > 0";

}



//Remove domain to cart
function removeDomain($domain) {
    global $cartId, $ovh;

    //Get Updated Cart
    $items = $ovh->get("/order/cart/".$cartId."/item");

    //Each item of the cart
    foreach ($items as $elm) {

        $name = $ovh->get("/order/cart/".$cartId."/item/".$elm)['settings']['domain'];

        //If elm name is domain we want to remove
        if($name == $domain) {
            $rm = $ovh->delete("/order/cart/".$cartId."/item/".$elm);
        }

    }

}



//Return domain list in cart
function updateDomain() {
    global $cartId, $ovh;

    $list = "";

    //Get Updated Cart
    $items = $ovh->get("/order/cart/".$cartId."/item");

    //Each item of the cart
    foreach ($items as $elm) {

        $name = $ovh->get("/order/cart/" . $cartId . "/item/" . $elm)['settings']['domain'];

        $list = $list . $name . ",";

    }

    echo($list."2");
}



// Create owner Contact
function createContact() {
    global $ovh, $user;

    $contact = $ovh->post("/me/contact", $user);

    $_SESSION['contactId'] = $contact['id'];
}



//Get informations
function getInfo() {
    global $cartId;

    $data = "";

    if(isset($cartId)){
        $data = $data.$cartId.",";
    } else {
        $data = $data."Aucun,";
    }

    if(isset($_SESSION['contactId'])){
        $data = $data.$_SESSION['contactId'].",";
    } else {
        $data = $data."Aucun,";
    }

    echo ($data."3");
}



// Assign contact to each cart item (domain)

function validation() {

    echo "Les noms de domaine ont été réservé";
//foreach($cart['items'] as $item) {
//    echo "\nAssign owner contact to cart item $item";
//    $domain = $ovh->post("/order/cart/" . $cartId . '/item/' . $item . '/configuration', [
//        "label" => "OWNER_CONTACT",
//        "value" => '/me/contact/' . $contact['id']
//    ]);
//}

}



// Bind a cart to your account
//echo "\nBind cart to account";
//$ovh->post("/order/cart/".$cartId."/assign");
//
//// Let's checkout
//echo "\nCheckout";
//$salesorder = $ovh->post("/order/cart/".$cartId."/checkout");
//var_dump($salesorder);
