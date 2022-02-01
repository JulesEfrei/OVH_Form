<?php

    include_once ("Model/request.php");


    function home() {

        include_once ("Template/home_page.php");


        // If data exist
        if(isset($_POST) && !empty($_POST)) {

            //ask cartId
            $cartId = getCartId();

            //Ask domain
            $exist = askDomain($cartId);


            //Echo domain avaibility
            echo ("Le nom de domaine " . $exist['domain'] . " : " . "est " . $exist['is_orderable']);


        }


    }

    function getCartId() {

        $post = new PostReq();

        $array = [
            "description"=>"Ask new cartId",
            "expire"=>"2022-01-31T18:30:24+00:00", // REMOVE THIS LINE FOR PRODUCTION
            "ovhSubsidiary"=>"FR"
        ];

        $data = $post->makePostReq("https://www.ovh.com/engine/apiv6/order/cart/", $array);
        $cartId = json_decode($data, true)["cartId"];

        return $cartId;

    }

    function askDomain($cartId) {

        $get = new GetReq();
        $domain = $_POST['domain'];


        $d = $get->makeGetReq("https://www.ovh.com/engine/apiv6/order/cart/$cartId/domain?domain=$domain");

        $is_orderable = json_decode($d, true)[0]["orderable"];

        $construct = [
            "domain"=> $domain,
            "is_orderable"=>$is_orderable
        ];

        return $construct;
    }



    // https://www.ovh.com/engine/apiv6/order/cart/
    //https://www.ovh.com/engine/apiv6/order/cart/d84a4952-9cd7-4e83-976f-19d9c6e5874e/domain?domain=monsite.com