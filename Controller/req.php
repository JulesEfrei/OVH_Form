<?php

function getCartId() {

    $post = new PostReq();

    $array = [
        "description"=>"Ask new cartId",
        "expire"=>"2022-02-01T16:00:00+00:00", // REMOVE THIS LINE FOR PRODUCTION
        "ovhSubsidiary"=>"FR"
    ];

    $data = $post->makePostReq("https://www.ovh.com/engine/apiv6/order/cart/", $array);
    $cartId = json_decode($data, true)["cartId"];

    return $cartId;

}

function askDomain($cartId) {

    $get = new GetReq();
    $domain = $_POST['domain'];

    // Make request
    $d = $get->makeGetReq("https://www.ovh.com/engine/apiv6/order/cart/$cartId/domain?domain=$domain");

    // Process the response
    //If not error
    if(isset(json_decode($d, true)[0]["orderable"])) {

        $data = json_decode($d, true)[0];

        if($data['orderable'] == 1 && str_contains($data['offerId'], "create")) {
            $construct = [
                "domain"=> $domain,
                "is_orderable"=>$data['orderable']
            ];
        } else {
            $construct = [
                "domain"=> $domain,
                "is_orderable"=>0
            ];
        }

    } else { // Error ==> Invalid syntaxe
        $construct = [
            "domain"=> $domain,
            "is_orderable"=>2 // => render invalid syntaxe in the views
        ];
    }


    return $construct;
}
